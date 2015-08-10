<?php


$app->get($app_config['url_prefix'], function() use ($app,$app_config){
    
    
    $app->render('/index.php',array(
        'app_config'=>$app_config
    ));
   
});


/* ----------------------------------------------------------------------------- */
/* ------------------------------ P R O D U C T S ------------------------------ */
/* ----------------------------------------------------------------------------- */

$app->group($app_config['url_prefix'].'/product', function () use ($app,$app_config){
    
        $app->post('/getCatList', function() use ($app){
            json_output( EAV::getCategoryListByParent($_POST['catid']) );
        });
        $app->post('/getProductList', function() use ($app){
            json_output( EAV::getProductListByParent($_POST['catid'], array('id','title','cat')) );
        });

        
        
        $app->post('/getAccessList', function(){
            json_output( EAV::getAccessList() );
        });
        
        /*--------------- C A T E G O R Y ---------------*/
        
        
        $app->post('/sortCategories', function() use ($app){
            json_output( EAV::sortCategories($_POST['list'], $_POST['parentId']) );
        });
        
        $app->post('/changeCategoryParent', function() use ($app){
            json_output( EAV::changeCategoryParent($_POST['itemId'], $_POST['newParentId']) );
        });
        
        $app->post('/addCategory', function() {
            json_output( EAV::addCategory($_POST['title'],$_POST['type'],$_POST['categoryid'],$_POST['access']) );
        });
        
        $app->put('/editCategory/:id', function($id) {
            json_output( EAV::editCategory($id,$_POST['title'],$_POST['type'],$_POST['categoryid'],$_POST['access']) );
        });
    
        $app->delete('/deleteCategory/:id', function($id){
            json_output( EAV::deleteCategory($id) ); 
        });
        
        /*--------------- T Y P E ---------------*/
        
        $app->post('/getProductType', function(){
            json_output( EAV::getProductTypes() );
        });
        
        $app->post('/addProductType', function() {
            json_output( EAV::addProductType($_POST['title'],$_POST['fields']) );
        });
        
        $app->put('/editProductType/:id', function($id) use($app_config){
            EAV::$app_config = $app_config;
            json_output( EAV::editProductType($id,$_POST['title'],$_POST['fields'],$_POST['deletedfieldsets'],$_POST['deletedfields']) );
        });
        
        $app->post('/getProductTypeByid/:id', function($id) {
            json_output( EAV::getProductTypeByid($id) );
        });
        
        $app->delete('/deleteProductType/:id', function($id){
            json_output( EAV::deleteProductType($id,$_POST['force']) ); 
        });
        
        
        /*--------------- P R O D U C T ---------------*/
        
        $app->post('/upload/', function() use($app_config){
            json_output($app_config['uploadFunction']($_FILES['file'])); 
        });
        
        $app->post('/addProduct/', function() use($app_config){
            json_output(EAV::addProduct($_POST['data'],$_POST['catid'])); 
        });
        
        $app->post('/getProductData/:id', function($id) use($app_config)
        {
            $options = array(
                'baseUrlPath'   =>  $app_config['UploadFolderUrl']
            );
            json_output(EAV::getProductData($id,$options)); 
        });
        
        $app->put('/editProduct/:id', function($id) use($app_config){
            json_output(EAV::editProduct($id,$_POST['data'],$_POST['catid'])); 
        });
        
        $app->delete('/deleteProduct/:id', function($id) use($app_config){
            json_output(EAV::deleteProduct($id)); 
        });
    
    
});















function json_output($data)
{
    header("Content-Type: application/json");
        echo json_encode(array(
            'data'=>$data
        ),JSON_NUMERIC_CHECK);
}

/*
$app->notFound(function () use ($app) {
    die('404 not found');
});
 */
<?php



$app->get($app_config['url_prefix'], function() use ($app,$app_config){
    
    $app->render('/index.php',array(
        'app_config'=>$app_config
    ));
   
});


/* ------------------------------ P R O D U C T S ------------------------------ */

$app->group($app_config['url_prefix'].'/product', function () use ($app){
    
    
        $app->post('/getCatList', function() use ($app){
            json_output( EAV::getCategoryListByParent($_POST['catid']) );
        });
        $app->post('/getProductList', function() use ($app){
            json_output( EAV::getProductListByParent($_POST['catid'], array('id','title','cat')) );
        });

        $app->post('/sortCategories', function() use ($app){
            json_output( EAV::sortCategories($_POST['list'], $_POST['parentId']) );
        });

        $app->post('/changeCategoryParent', function() use ($app){
            json_output( EAV::changeCategoryParent($_POST['itemId'], $_POST['newParentId']) );
        });
        
        $app->post('/getProductType', function() use ($app){
            json_output( EAV::getProductTypes() );
        });
    
    
});















function json_output($data)
{
    header("Content-Type: application/json");
    echo json_encode($data);
}

/*
$app->notFound(function () use ($app) {
    die('404 not found');
});
 */
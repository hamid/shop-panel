<?php

$app_config = array(
        /*
	|--------------------------------------------------------------------------
	| Application url_prefix
	|--------------------------------------------------------------------------
	|
	| first section of URl in all route.
        | its useful when you want to separate this app from main site.
	|
	*/
           // [LOCAL CHANGE]  'url_prefix' => '/'
          'url_prefix'      => '/cp_'.SHOP_URL,
    
    
        /*
	|--------------------------------------------------------------------------
	| Application authentication
	|--------------------------------------------------------------------------
	|
	| a function that check user is authenticated.
        | its clear that login page should be shown if user is not authenticated.
	| this function return true if user is authenticated.
        |
	*/
          'authentication' => function(){
            return true;
          },
                  
                  
        /*
	|--------------------------------------------------------------------------
	| Application language
	|--------------------------------------------------------------------------
	|
	| app language , contain all words , date and currency  
	| your language should have json file in frontend/translation directory
	| the value shuld be locale ID(i18n)
        |
	*/
        // [LOCAL CHANGE]  'language' => 'en-us'
          'language' => 'fa-ir',
                  
                  
        /*
	|--------------------------------------------------------------------------
	| Application direction
	|--------------------------------------------------------------------------
	|
	| direction of text and box of panel. it depends on your language
        | it could be `ltr` => Left  To Right
        | or          `rtl` => Right To Left
        |
	*/
        // [LOCAL CHANGE]  'direction' => 'ltr'
          'direction' => 'rtl',
                  
                       
        /*
	|--------------------------------------------------------------------------
	| Application template
	|--------------------------------------------------------------------------
	|
        | name of panel template , its directory in /frontend/template,
        | it contains css and less files of template, you could build your own
        | template by cloning the base template and change the below key
        |
	*/
          'template' => 'base',
                  
                       
        /*
	|--------------------------------------------------------------------------
	| Application maxSearchableField
	|--------------------------------------------------------------------------
	|
        | maximum count of field that could be searchable in each product type
        |
	*/
          'maxSearchableField' => 5,
                  
                  
                  
        /*
	|--------------------------------------------------------------------------
	| Application Upload Function
	|--------------------------------------------------------------------------
	|
        | this function is called  when the file is uploaded
        |
	*/
        //  [LOCAL CHANGE]   'uploadFunction' => 'return true'
          'uploadFunction' => function($file)
            {
              Core::loadLib('Admin',LIB_DIR.DIRECTORY_SEPARATOR.'Admin');
              Core::loadLib('fileManager',LIB_DIR.DIRECTORY_SEPARATOR.'Admin');
              
              //-> Permission Check
//                if(!Admin::checkModAccess('__upload', 'upload'))
//                {
//                    Core::jsonError('No Permission');
//                    return array('stat'=>false,'mes'=>'No Permission');
//                }
                
              // Create Product Folder
              $productFolderId = FileManager::createFolder('Product', '0');
              if(!$productFolderId)
                  $productFolderId = FileManager::$existingFolderId;
              
              
              
              $allow_ext = array('png','jpg','bmp','gif');
              $file_name = time().FileManager::mkRndStr(5);

              return FileManager::upload($file,$file_name,$productFolderId,$allow_ext,false,Admin::$uname);
          },
          
          /*
	|--------------------------------------------------------------------------
	| Application Upload Folder Url 
	|--------------------------------------------------------------------------
	|
        | full url of  uploaded file
        |
	*/
        //  [LOCAL CHANGE]   'UploadFolderUrl' => ''
          'UploadFolderUrl' => Core::$CDN.'site'.'/'.Core::$Setting->package.'/'
                  
        
);


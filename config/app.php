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
          'url_prefix'      => '/',
    
    
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
          'language' => 'en-us',
                  
                  
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
          'direction' => 'ltr',
                  
                       
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
          'template' => 'base'
                  
        
);


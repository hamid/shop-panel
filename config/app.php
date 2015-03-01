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
          'language' => 'en-us'
                  
        
);


<?php

$db_config = array(
        /*
	|--------------------------------------------------------------------------
	| Database Driver Config
	|--------------------------------------------------------------------------
        |
	| our app use mysqli extension to connect  mysql
        |
	*/
              'database' => 'admin_cms_shop 1',
              'username' => 'root',
              'password' => '',
    
    
        /*
	|--------------------------------------------------------------------------
	| Database Tables Name
	|--------------------------------------------------------------------------
        |
	| name of products and its categories ... tables 
        |
	*/
              'tables' =>array(
                    'categories'  =>  'product_cat',
                    'products'    =>  'product'
              )
);


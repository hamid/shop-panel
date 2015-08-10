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
                    'categories'            =>  'product_cat',
                    'products'              =>  'product',
                    'products_description'  =>  'product_description',
                    'products_image'        =>  'product_image',
                    'products_type_fields'  =>  'product_type_field_value',
                    'type'                  =>  'product_type',
                    'type_fields'           =>  'product_type_field',
                    'type_fieldset'         =>  'product_type_fieldset',
                    'type_fields_value'     =>  'product_type_field_value',
              ),
    
    
        /*
	|--------------------------------------------------------------------------
	| Database other Config
	|--------------------------------------------------------------------------
        |
	| if your app has specific condition on each tables , you could set here
        | appCondition should contain `and`,`or` at its end
        | appExtraField and appExtraFieldValue  should contain `,` at end 
        |
	*/
              //  [LOCAL CHANGE]   'appCondition' => ''
              'appCondition'        => ' `site_id`="'.Core::$SITE_ID.'" AND ',
              'appExtraField'       => ' `site_id` , ',
              'appExtraFieldValue'  => Core::$SITE_ID.' , ',
);


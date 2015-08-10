<?php
/**
 * Shop Panel
 * 
 * @author Hamid Reza Salimian (github.com/hamid)
 * @copyright 2015
 * @version 1.0
 * 
 */



/*
|--------------------------------------------------------------------------
| Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application.
|
*/
require __DIR__.'/vendor/autoload.php';


/*
|--------------------------------------------------------------------------
| Application Config
|--------------------------------------------------------------------------
|
| Contains all config for our shop application
| config of database ,application and slim framework 
|
*/
require __DIR__.'/config/loader.php';



/*
|--------------------------------------------------------------------------
| Database Driver
|--------------------------------------------------------------------------
|
| a simple class that connect to mysql and has methods for working with it
|
*/
//  [LOCAL CHANGE]   require __DIR__.'/lib/driver.php';
$driver     =   new DB;
$driver->connect(
                    $db_config['username'],
                    $db_config['password'],
                    $db_config['database']
                );


/*
|--------------------------------------------------------------------------
| EAV  Class
|--------------------------------------------------------------------------
|
| EAV :Entity attribute value, a class contains methods for Create, Read,
| Update and Delete Product,Category based on EAV model in Database
| the outputs of methods are usually objects of products or category 
|
*/
require __DIR__.'/lib/eavModel.php';

eav::setDriver($driver);

/*
|--------------------------------------------------------------------------
| Base,Category,Pruduct,Type Class
|--------------------------------------------------------------------------
|
| contain  methods for fetch, Create, Update and Delete Categories,Pruducts
|
*/
require __DIR__.'/lib/Base.php';
require __DIR__.'/lib/Category.php';
require __DIR__.'/lib/Product.php';
require __DIR__.'/lib/Type.php';

Base::$driver                =   $driver;
Base::$appCondition          =   $db_config['appCondition'];
Base::$appExtraField         =   $db_config['appExtraField'];
Base::$appExtraFieldValue    =   $db_config['appExtraFieldValue'];

Category::setOption(
                    array(
                          'table'          =>  $db_config['tables']['categories'],
                          'productTable'   =>  $db_config['tables']['products']
                    )
);
Product::setOption(
                    array(
                          'table'               =>  $db_config['tables']['products'],
                          'table_image'         =>  $db_config['tables']['products_image'],
                          'table_description'   =>  $db_config['tables']['products_description'],
                          'table_type_fields'   =>  $db_config['tables']['products_type_fields'],
                          'table_type_structure_fields'   =>  $db_config['tables']['type_fields']
                    )
);
Type::setOption(
                    array(
                          'table'               =>  $db_config['tables']['type'],
                          'table_fields'        =>  $db_config['tables']['type_fields'],
                          'table_fieldset'      =>  $db_config['tables']['type_fieldset'],
                          'table_fields_value'  =>  $db_config['tables']['type_fields_value'],
                          'category_table'      =>  $db_config['tables']['categories'],
                          'product_table'       =>  $db_config['tables']['products']
                    )
);









/*
|--------------------------------------------------------------------------
| Slim FrameWork
|--------------------------------------------------------------------------
|
| This shop uses Slim for backend .it's very light and simple
| its documents :http://docs.slimframework.com/
|
*/
$app = new \Slim\Slim($slim_config);



/*
|--------------------------------------------------------------------------
| Routing 
|--------------------------------------------------------------------------
|
| this file contains all registerd routes  for our application
| 
*/
require __DIR__.'/routes.php';

$app->run();




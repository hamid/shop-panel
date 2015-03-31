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
require __DIR__.'/lib/driver.php';
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
| Category,Pruduct Class
|--------------------------------------------------------------------------
|
| contain  methods for fetch, Create, Update and Delete Categories,Pruducts
|
*/
require __DIR__.'/lib/Category.php';
require __DIR__.'/lib/Product.php';

Category::setOption(
                    array(
                          'driver'  =>  $driver,
                          'table'   =>  $db_config['tables']['categories']
                    )
);
Product::setOption(
                    array(
                          'driver'  =>  $driver,
                          'table'   =>  $db_config['tables']['products']
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




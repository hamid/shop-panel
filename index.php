<?php
/**
 * 
 * 
 * @package xsxhamid
 * @author Hamid Reza Salimian
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
| EAV & product Class
|--------------------------------------------------------------------------
|
| EAV :Entity attribute value, a class contains methods for Create, Read,
| Update and Delete Product based on EAV model in Database
|
*/
require __DIR__.'/lib/eavModel.php';
require __DIR__.'/lib/product.php';
eav::setDriver($driver);




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




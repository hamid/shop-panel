<?php

/*
|--------------------------------------------------------------------------
| Slim Framework
|--------------------------------------------------------------------------
|
| config for slim , we use slim for routing
| you could see http://docs.slimframework.com for more information and config
|
*/

$slim_config = array(
    
    /*
    |--------------------------------------------------------------------------
    | Slim debug
    |--------------------------------------------------------------------------
    |
    | If debugging is enabled, Slim will use its built-in error handler to
    | display diagnostic information for uncaught Exceptions. If debugging is
    | disabled, Slim will instead invoke your custom error handler passing
    | it the otherwise uncaught Exception as its first and only argument.
    |
    */
    'debug'             => true,
    
    /*
    |--------------------------------------------------------------------------
    | Slim log.enabled
    |--------------------------------------------------------------------------
    |
    | This enables or disables Slim’s logger. To change this setting after
    | instantiation you need to access Slim’s logger directly and use its
    | setEnabled() method.
    |
    */
    'log.enabled'       => true,
    
    /*
    |--------------------------------------------------------------------------
    | Slim mode
    |--------------------------------------------------------------------------
    |
    |  This is an identifier for the application’s current mode of operation.
    |  The mode does not affect a Slim application’s internal functionality.
    |  Instead, the mode is only for you to optionally invoke your own code
    |  for a given mode with the configMode() application method.
    |  The application mode is declared during instantiation, either as an
    |  environment variable or as an argument to the Slim application
    |  constructor. It cannot be changed afterward. The mode may be anything
    |  you want — “development”, “test”, and “production” are typical, but you
    |  are free to use anything you want (e.g. “foo”)
    |
    */
    'mode'              => 'development',
    
    
    /*
    |--------------------------------------------------------------------------
    | Slim cookies.encrypt
    |--------------------------------------------------------------------------
    |
    | Determines if the Slim app should encrypt its HTTP cookies.
    |
    */
    'cookies.encrypt'   => true,
    'cookies.secret_key'=> 'PIM_SHOP',
     
    
    
    
    /*
    |--------------------------------------------------------------------------
    | Application Template Directory
    |--------------------------------------------------------------------------
    |
    | The relative or absolute path to the filesystem directory that
    | contains your Slim application’s template files. This path is 
    | eferenced by the Slim application’s View to fetch and render templates
    | To change this setting after instantiation you need to access Slim’s
    | view directly and use its setTemplatesDirectory() method.
    |
    */        
    'templates.path' =>'.\frontend'
        
);


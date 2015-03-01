<?php


$app->get($app_config['url_prefix'], function () use ($app,$app_config){
    
    $app->render('/index.php',array(
        'app_config'=>$app_config
    ));
   
});
$app->get($app_config['url_prefix'].'/hello/:name', function ($name) use ($app){
    echo "Hello, $name . its test.";
});

/*
$app->notFound(function () use ($app) {
    die('404 not found');
});
 */
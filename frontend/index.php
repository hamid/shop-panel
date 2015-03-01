<!DOCTYPE html>
<html lang="en" ng-app="mainApp" >
<head>
  
  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-Shop</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="frontend/" target="_blank"> 
  <link rel="stylesheet" href="bower_components/html5-boilerplate/css/normalize.css">
  <link rel="stylesheet" href="bower_components/html5-boilerplate/css/main.css">
  <script src="bower_components/html5-boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
  
</head>
<body>
  <ul class="menu">
    <li><a href="#/statistics">statistics</a></li>
    <li><a href="#/products">products</a></li>
  </ul>

  <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <div ng-view>
      
  </div>

  <!--[ Angular Library ]-->
  <script src="bower_components/angular/angular.js"></script>
  <script src="bower_components/angular-route/angular-route.js"></script>
  <script src="bower_components/angular-resource/angular-resource.min.js"></script>
      

  <script src="bower_components/angular-i18n/angular-locale_en-us.js"></script>
 
  <!--App Config-->
<script type="text/javascript">
    window.appConfig = {
           language:"<?php echo($app_config['language']); ?>",
           direction:""
    };
</script>
  
  <!--main module and router-->
  <script src="app.js"></script>
  <script src="services.js"></script>
  
  
  
  <!-- Controllers -->
  <script  src="controllers/statistics.js"></script>
  <script  src="controllers/products.js"></script>
  

</body>
</html>
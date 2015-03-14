<!DOCTYPE html>
<html lang="en" ng-app="mainApp" >
<head> 
  
  <base href="./frontend/" target="_blank">   
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-Shop</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  
  
  <link rel="stylesheet" href="bower_components/html5-boilerplate/css/normalize.css">
  <link rel="stylesheet" href="bower_components/html5-boilerplate/css/main.css">
  <script src="bower_components/html5-boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
  
  <!-- Angular Material Dependencies -->
  <link rel="stylesheet" href="bower_components/angular-material/angular-material.min.css">
  
  <!-- Css of Template -->
  <link rel="stylesheet" href="template/<?php echo($app_config['template']); ?>/style.css">
  <!-- Css of Panel Language -->
  <link rel="stylesheet" href="template/<?php echo($app_config['template'].'/lang/'.$app_config['language']); ?>/style.css">
  
</head>
<body class=" <?php echo($app_config['direction']); ?> " layout="row">
    
  <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  
      
      <!--Sidebar-->
      <div class="sidebar animated fadeInSide" flex="5">
        <?php include(__DIR__.'/sidebar.html'); ?>
      </div>
      
      <!--TopMenu-->
      <div class="center-box" flex layout="column">
        <?php include(__DIR__.'/topMenu.html'); ?>
          
      <!--Main Box-->
        <div  layout="column" flex ng-view></div>
        
      </div>
      
      
    
      
    <!--Footer-->
    <?php include(__DIR__.'/footer.html'); ?>

  
    
    
    <!--[ Angular Library ]-->
    <script src="bower_components/angular/angular.js"></script>
    <script src="bower_components/angular-route/angular-route.js"></script>
    <script src="bower_components/angular-resource/angular-resource.min.js"></script>

    <!-- Angular Material Dependencies -->
    <script src="bower_components/angular-animate/angular-animate.min.js"></script>
    <script src="bower_components/angular-aria/angular-aria.min.js"></script>
    <script src="bower_components/angular-material/angular-material.min.js"></script>
  
    <script src="bower_components/angular-i18n/angular-locale_en-us.js"></script>
 
    <!--App Config-->
    <script type="text/javascript">
        window.appConfig = {
               language:"<?php echo($app_config['language']); ?>",
               direction:"<?php echo($app_config['direction']); ?>"
        };
    </script>


    <!-- Main Module and Router -->
    <script src="app.js"></script>
    <script src="services.js"></script>
  
  
    <!-- Controllers -->
    <script  src="controllers/statistics.js"></script>
    <script  src="controllers/products.js"></script>
    <script  src="controllers/topMenu.js"></script>
    <script  src="controllers/sidebar.js"></script>
  

</body>
</html>
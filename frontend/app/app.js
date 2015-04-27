// Declare app level module which depends on views, and components

var mainApp     =   angular.module('mainApp', [
    'TranslateService',
    'ProductFactory',
    
    'ngRoute',
    'ngMaterial',
    'ngMessages',
    'ui.sortable'
])
.config(['$routeProvider','$mdThemingProvider',
  function($routeProvider,$mdThemingProvider) {
   /* ----- ROUTING ----- */
    $routeProvider.
            
      when('/statistics', {
            templateUrl: 'app/view/statistics.html',
            controller: 'StatisticsCtrl'
      })
      
      .when('/products', {
            templateUrl: 'app/view/product/product.html',
            controller: 'ProductsCtrl'
      })
      
      .otherwise({
            redirectTo: '/products'
      });
      
      
   /* ----- Color UI ----- */
    $mdThemingProvider.definePalette('MainColor', {
        '50'  : '21759b',
        '100' : '21759b',
        '200' : '21759b',
        '300' : '21759b',
        '400' : '21759b',
        '500' : '21759b',
        '600' : '21759b',
        '700' : '21759b',
        '800' : '21759b',
        '900' : '21759b',
        'A100': '21759b',
        'A200': '21759b',
        'A400': '21759b',
        'A700': '21759b',
        'A900': '555',
        'contrastDefaultColor': 'light',    // whether, by default, text (contrast)
                                            // on this palette should be dark or light
        'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
         '200', '300', '400', 'A100'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
      });
    $mdThemingProvider.theme('default')
                      .primaryPalette('MainColor')
                      .accentPalette('orange');
              
    

      
      
  }]);
   


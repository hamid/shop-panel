// Declare app level module which depends on views, and components

var mainApp     =   angular.module('mainApp', [
    'TranslateService',
    'ProductFactory',
    'DynamicFieldDirective',
    'DynamicProductFieldDirective',
    
    'ngRoute',
    'ngMaterial',
    'ngFileUpload',
    'ngMessages',
    'ui.sortable',
    'ngQuill',
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
    
    // Second Theme  : red
    $mdThemingProvider.definePalette('redPalette', {
        '50'  : 'e74c3c',
        '100' : 'e74c3c',
        '200' : 'e74c3c',
        '300' : 'e74c3c',
        '400' : 'e74c3c',
        '500' : 'e74c3c',
        '600' : 'e74c3c',
        '700' : 'e74c3c',
        '800' : 'e74c3c',
        '900' : 'e74c3c',
        'A100': 'e74c3c',
        'A200': 'e74c3c',
        'A400': 'e74c3c',
        'A700': 'e74c3c',
        'A900': '555',
        'contrastDefaultColor': 'light',    
        'contrastDarkColors': ['50', '100', 
         '200', '300'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
      });
    $mdThemingProvider.theme('red')
                      .primaryPalette('redPalette')
                      .accentPalette('MainColor');
              
    
    // third Theme  : green
    $mdThemingProvider.definePalette('greenPalette', {
        '50'  : '2ecc71',
        '100' : '2ecc71',
        '200' : '2ecc71',
        '300' : '2ecc71',
        '400' : '2ecc71',
        '500' : '2ecc71',
        '600' : '2ecc71',
        '700' : '2ecc71',
        '800' : '2ecc71',
        '900' : '2ecc71',
        'A100': '2ecc71',
        'A200': '2ecc71',
        'A400': '2ecc71',
        'A700': '2ecc71',
        'A900': '555',
        'contrastDefaultColor': 'light',    
        'contrastDarkColors': ['50', '100', 
         '200', '300'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
      });
    $mdThemingProvider.theme('green')
                      .primaryPalette('greenPalette')
                      .accentPalette('MainColor');
              
    

      
      
  }]);
   


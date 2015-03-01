// Declare app level module which depends on views, and components

var mainApp     =   angular.module('mainApp', [
    'TranslateService',
    'ngRoute',
])
.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
            
      when('/statistics', {
            templateUrl: 'view/statistics.html',
            controller: 'StatisticsCtrl'
      })
      
      .when('/products', {
            templateUrl: 'view/product.html',
            controller: 'ProductsCtrl'
      })
      
      .otherwise({
            redirectTo: '/statistics'
      });
  }]);
   



/*
|--------------------------------------------------------------------------
| DynamicProductField
|--------------------------------------------------------------------------
| service DynamicProductField 
| Directive Name : DynamicProductField
| 
*/
var DynamicProductFieldDirective = angular.module('DynamicProductFieldDirective', ['ngResource']);    
DynamicProductFieldDirective.directive('dynamicProductField', function() {
  return {
    restrict: 'E',
    transclude: true,
    scope: {
      fields                :'=fields',
    },
    templateUrl: 'app/directives/templates/DynamicProductField.html?v=1.003'
  };
});


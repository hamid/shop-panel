
/*
|--------------------------------------------------------------------------
| DynamicField
|--------------------------------------------------------------------------
| service DynamicField 
| Directive Name : DynamicField
| 
*/
var DynamicFieldDirective = angular.module('DynamicFieldDirective', ['ngResource']);    
DynamicFieldDirective.directive('dynamicField', function() {
  return {
    restrict: 'E',
    transclude: true,
    scope: {
      fields                : '=fields',
      searchablecaption     :'=searchablecaption',
      addfieldcaption       :'=addfieldcaption',
      addfieldplaceholder   :'=addfieldplaceholder',
      removefieldsetcaption :'=removefieldsetcaption',
      dynamicFieldSortableOptions:'=sort',
      'showFields'          : '&onShowfields',
      'remove'              : '&onRemove',
      'removefieldset'      : '&onRemovefieldset',
      'onsearchablechange'  : '&onSearchableChange'
    },
    templateUrl: 'app/directives/templates/dynamicField.html?v=1.004'
  };
});


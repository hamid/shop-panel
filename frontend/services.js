
/*
|--------------------------------------------------------------------------
| TranslateService
|--------------------------------------------------------------------------
| service translate text in templates
| Service Name : Translate
| usage        : call `Translate.getTranslation($scope, 'en');`  and use 
|                `Translate.WORD` in templates.
                 it uses json file in `translation` directory.
*/
var TranslateService = angular.module('TranslateService', ['ngResource']);    
TranslateService.factory('Translate', ['$resource','$http',
  function($resource,$http){
      
   /*  ----- [ M E T H O D S] -----  */
    this.getTranslation = function($scope, language)
    {
        var languageFilePath = 'translation/translation_' + language + '.json';
        $http.get(languageFilePath).
            success(function(data, status, headers, config) {
              $scope.Translate = data;
            }).
            error(function(data, status, headers, config) {alert('error in loading language:Translate Service');});
    };
        
    return this;
  }]);    


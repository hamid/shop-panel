
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
      
    var TranslateData = false;  
   /*  ----- [ M E T H O D S] -----  */
    this.getTranslation = function($scope, language)
    {
        if(TranslateData)
        {
            return $scope.Translate=  TranslateData;
        }
        var languageFilePath = 'translation/translation_' + language + '.json';
        $http.get(languageFilePath).
            success(function(data, status, headers, config) {
              return TranslateData = $scope.Translate = data;
            }).
            error(function(data, status, headers, config) {alert('error in loading language:Translate Service');});
    };
    
    this.translateByObject = function(string,obj)
    {
        for(items in obj)
        {
            if(items)
                string = string.replace('['+items+']',obj[items]);
        }
        return string;
    }
        
    return this;
  }]);    



/*
|--------------------------------------------------------------------------
| FieldGeneratorService
|--------------------------------------------------------------------------
| service Generator field in template via `schema-form` lib
| Service Name : FieldGenerator
| 
*/
var FieldGeneratorService = angular.module('FieldGeneratorService', ['ngResource']);    
FieldGeneratorService.factory('FieldGenerator', ['$resource','$http',
  function($resource,$http){
      
      
   /*  ----- [ M E T H O D S] -----  */
    this.getFields = function($scope, language)
    {
        var fields = [
            {name:'text field',title:'tiitle',type:'text'},
            {name:'select box',title:'tiitle','extraField' : this.selectbox.extrafield},
        ];
        
        return fields;
    };
    
    
    this.selectbox = {
        extrafield:function(fieldName){
            return {
                "key" : fieldName,
                "type": 'chips',
                "model":'mooodel',
                "title":'mooodel',
                "placeholder":'ppppppp'
            }
        }
    }
        
    return this;
  }]);    


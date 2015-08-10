mainApp.controller('typeDialog', ['$scope', 'parentScope','ProductFactory','mode','callback','$http','event','$mdDialog','$mdToast','$mdBottomSheet','Translate',
function ($scope,parentScope,ProductFactory,mode,callback,$http,event,$mdDialog, $mdToast,$mdBottomSheet,Translate) {
    
    
                                        $scope.parent           = parentScope;
                                        $scope.mode             = mode; /* edit or add */
                                        /* ------------ Initialize ------------ */
                                        ProductFactory.init(parentScope,$http);
                                        
                                        // Dynamic Fields
                                        $scope.dynamicFields    = [];
                                        $scope.fieldNumber      = 0;
                                        $scope.isTypeLoading    = {};
                                        
                                        
                                        $scope.closeDialog      = function() {
                                            if(typeof callback == 'function')
                                                callback();
                                            $mdDialog.cancel();
                                            return false;
                                        };
                                        $scope.initialFieldsProperties = [
                                                {type:'textbox'  ,icon:'pshop-input',fieldTypeCaption:parentScope.Translate.PRODUCT.DYNAMIC_FIELD_TEXT,title:parentScope.Translate.TITLE + parentScope.Translate.PRODUCT.DYNAMIC_FIELD_TEXT},
                                                {type:'selectbox',icon:'pshop-list-ul',fieldTypeCaption:parentScope.Translate.PRODUCT.DYNAMIC_FIELD_SELECTBOX,title:parentScope.Translate.TITLE + parentScope.Translate.PRODUCT.DYNAMIC_FIELD_SELECTBOX,placeholder:parentScope.Translate.PRODUCT.DYNAMIC_FIELD_SELECTBOX_ADD,placeholder2:parentScope.Translate.PRODUCT.DYNAMIC_FIELD_SELECTBOX_ADD},
                                                {type:'checkbox'  ,icon:'pshop-check-box',fieldTypeCaption:parentScope.Translate.PRODUCT.DYNAMIC_FIELD_CHECKBOX,title:parentScope.Translate.TITLE + parentScope.Translate.PRODUCT.DYNAMIC_FIELD_CHECKBOX},
                                        ];
                                        
                                        /* BottomSheet */
                                        $scope.showFields       = function(event,fieldset){
                                            
                                            $mdBottomSheet.show({
                                              template   : '<md-bottom-sheet class="md-grid field-list"><md-list>   <md-list-item class="item animated fadeIn delay-{{($index!=0)?$index+1:0}}"   ng-repeat="item in fields"><div ng-click="fieldClick('+fieldset.id+',item)"> <div class="icon {{item.icon}}"></div> <md-button  ng-click="fieldClick(item)" class="md-grid-item-content" ><div class="md-grid-text"> {{ item.fieldTypeCaption }} </div></md-button></md-list-item>   </div></md-list></md-bottom-sheet>',
                                              parent     : '.typeDialog',
                                              targetEvent: event,
                                              locals     : {typeDialogScope: $scope},
                                              controller : function($scope, $mdBottomSheet,typeDialogScope) {
                                                                $scope.fields = angular.copy(typeDialogScope.initialFieldsProperties);
                                                                
                                                                $scope.fieldClick = function(fieldsetId,item)
                                                                {
                                                                    /*Close other Fields*/
                                                                    for(i=0;i < typeDialogScope.dynamicFields.length ; i++)
                                                                        for(g=0;g < typeDialogScope.dynamicFields[i].field.length ; g++)
                                                                            typeDialogScope.dynamicFields[i].field[g].open = false;
                                                                    
                                                                    num           = typeDialogScope.fieldNumber++;
                                                                    item.open     = true;
                                                                    item.num      = num;
                                                                    item.model    = {
                                                                        title       :'',
                                                                        type        :item.type,
                                                                        priority    :item.type,
                                                                        fieldset_id :fieldsetId,
                                                                        searchable  :false,
                                                                        option:[]
                                                                    };
                                                                    for(i=0;i < typeDialogScope.dynamicFields.length ; i++)
                                                                        if(typeDialogScope.dynamicFields[i].id == fieldsetId)
                                                                            typeDialogScope.dynamicFields[i].field.push(item);
                                                                        
                                                                    $mdBottomSheet.cancel();
                                                                }
                                                            }
                                            });
                                            // prevent from bubbling
                                            if (event.stopPropagation) event.stopPropagation();
                                            if (event.preventDefault) event.preventDefault();
                                        }
                                        
                                        $scope.removeField      = function(item,fieldset)
                                        {
                                            var baseFieldsetIndex    = $scope.dynamicFields.indexOf(fieldset);
                                            var baseFieldIndex       = $scope.dynamicFields[baseFieldsetIndex]['field'].indexOf(item);
                                            
                                            $scope.dynamicFields[baseFieldsetIndex]['field'].splice(baseFieldIndex,1);
                                            if($scope.mode == 'edit' && item.model.id)
                                                $scope.deletedField.push(item.model.id);
                                        }
                                        
                                        $scope.removeFieldset      = function(fieldset)
                                        {
                                            var baseItemIndex    = $scope.dynamicFields.indexOf(fieldset);
                                            $scope.dynamicFields.splice(baseItemIndex,1);
                                            if($scope.mode == 'edit' && fieldset.id)
                                                $scope.deletedFieldset.push(fieldset.id);
                                        }
                                        
                                        $scope.typeClick        = function(item,$event)
                                        {
                                            $scope.isTypeLoading[item.id] = true;
                                            ProductFactory.getProductTypeByid(item.id)
                                                .then(function(item,data)
                                                {
                                                    $scope.resetForm('edit');
                                                    $scope.isTypeLoading[item.id] = false;
                                                    $scope.typeTitle              = item.title;
                                                    $scope.id                     = item.id;
                                                    TypeFields                    = [];
                                                    
                                                    for(s=0;s < item.fieldset.length;s++)
                                                    {
                                                        fieldArray = [];
                                                        for(i=0;i < item.fieldset[s].fields.length;i++)
                                                        {
                                                            //Find initial fields Properties object
                                                            var initialFieldsProperties = {};
                                                            for(g =0;g<$scope.initialFieldsProperties.length;g++)
                                                                if($scope.initialFieldsProperties[g].type == item.fieldset[s].fields[i].structure)
                                                                    initialFieldsProperties = $scope.initialFieldsProperties[g];

                                                            num           = $scope.fieldNumber++;
                                                            if(!item.fieldset[s].fields[i].options)
                                                                item.fieldset[s].fields[i].options = [];

                                                            fieldArray.push(
                                                                angular.extend({
                                                                    type    : item.fieldset[s].fields[i].structure,
                                                                    open    : false,
                                                                    num     : num,
                                                                    model   : {
                                                                                id          :item.fieldset[s].fields[i].id,
                                                                                priority    :item.fieldset[s].fields[i].priority,
                                                                                title       :item.fieldset[s].fields[i].title,
                                                                                type        :item.fieldset[s].fields[i].structure,
                                                                                fieldset_id :item.fieldset[s].fields[i].fieldset_id,
                                                                                searchable  :item.fieldset[s].fields[i].searchable,
                                                                                option      :item.fieldset[s].fields[i].options
                                                                              }
                                                                },initialFieldsProperties)
                                                            );
                                                        }/* end for of field */
                                                        $scope.dynamicFields.push({
                                                                id       :item.fieldset[s].id,
                                                                title    :item.fieldset[s].title,
                                                                priority :item.fieldset[s].priority,
                                                                field    :fieldArray,
                                                            });
                                                        
                                                        
                                                    }
                                                    
                                                },function(){
                                                    $scope.resetForm('edit');
                                                    $scope.isTypeLoading = false;
                                                });
                                        }
                                        
                                        $scope.addFieldset      = function()
                                        {
                                            $scope.dynamicFields.push({
                                                title    :'',
                                                priority :'',
                                                field    :[],
                                            });
                                            // prevent from bubbling
                                            if (event.stopPropagation) event.stopPropagation();
                                            if (event.preventDefault) event.preventDefault();
                                        }
                                        
                                        $scope.resetForm        = function(mode)
                                        {
                                            $scope.mode           = mode;
                                            $scope.deletedField   = [];
                                            $scope.deletedFieldset= [];
                                            $scope.addedField     = [];
                                            $scope.dynamicFields  = [];
                                            $scope.typeTitle      = '';
                                        }
                                        
                                        $scope.submitTypeForm   = function(TypeForm)
                                        {
                                            if($scope.mode == 'add')
                                                return $scope.addType(TypeForm);
                                            return $scope.editType(TypeForm);
                                        }
                                        
                                        $scope.addType          = function(form)
                                        {
                                            $scope.isloading = true;
                                            
                                           fieldsetArray        = [];
                                            for(j=0;j<$scope.dynamicFields.length;j++)
                                            {
                                                fieldsArray      = [];
                                                for(k=0;k<$scope.dynamicFields[j].field.length;k++)
                                                    fieldsArray.push($scope.dynamicFields[j].field[k]['model']);
                                                fieldsetArray.push({
                                                    id      :$scope.dynamicFields[j].id,
                                                    title   :$scope.dynamicFields[j].title,
                                                    field   :fieldsArray
                                                });
                                            }

                                            ProductFactory.addProductType(
                                                {
                                                    title       :$scope.typeTitle,
                                                    fields      :fieldsetArray,
                                                }
                                            ).then(function(data){
                                                $scope.isloading = false;
                                                $mdToast.show(
                                                    $mdToast.simple()
                                                        .content(parentScope.Translate.PRODUCT.TYPE_ADDED)
                                                        .position('top center')
                                                        .hideDelay(4000)
                                                        .theme('green')
                                                );
                                                /* callback of typeDialog's function */
                                                if(typeof callback == 'function')
                                                    callback(data);
                                                
                                            },function(){
                                                $scope.isloading = false;
                                                $mdToast.show(
                                                        $mdToast.simple()
                                                            .content(parentScope.Translate.PRODUCT.TYPE_NOT_ADDED)
                                                            .position('top center')
                                                            .hideDelay(4000)
                                                            .theme('red')
                                                );
                                            }); 
                                        };/* end addType  */
                                        
                                        $scope.editType          = function(form)
                                        {
                                            $scope.isEditloading = true;
                                            fieldsetArray        = [];
                                            for(j=0;j<$scope.dynamicFields.length;j++)
                                            {
                                                fieldsArray      = [];
                                                for(k=0;k<$scope.dynamicFields[j].field.length;k++)
                                                    fieldsArray.push($scope.dynamicFields[j].field[k]['model']);
                                                fieldsetArray.push({
                                                    id      :$scope.dynamicFields[j].id,
                                                    title   :$scope.dynamicFields[j].title,
                                                    field   :fieldsArray
                                                })
                                            }
                                            
                                            ProductFactory.editProductType(
                                                {
                                                    id           :$scope.id,
                                                    title        :$scope.typeTitle,
                                                    fields       :fieldsetArray,
                                                    deletedfields:$scope.deletedField,
                                                    deletedfieldsets:$scope.deletedFieldset,
                                                })
                                            .then(function(data){
                                                $scope.isEditloading = false;
                                                $mdToast.show(
                                                    $mdToast.simple()
                                                        .content(parentScope.Translate.PRODUCT.TYPE_EDITED)
                                                        .position('top center')
                                                        .hideDelay(4000)
                                                        .theme('green')
                                                );
                                                //update
                                                for(j=0;j<$scope.parent.typesList.length ; j++)
                                                    if($scope.parent.typesList[j]['id'] == $scope.id)
                                                        $scope.typeClick($scope.parent.typesList[j],false);
                                            },function(data){
                                                $scope.isEditloading = false;
                                                $mdToast.show(
                                                        $mdToast.simple()
                                                            .content(parentScope.Translate.PRODUCT.TYPE_NOT_ADDED)
                                                            .position('top center')
                                                            .hideDelay(4000)
                                                            .theme('red')
                                                );
                                            }); 
                                        };/* end editType  */
                                        
                                        
                                        $scope.deleteType = function()
                                        {
                                            $scope.isDeleteloading = true;
                                            ProductFactory.deleteProductType(
                                                {
                                                    id           :$scope.id,
                                                    force        :0
                                                })
                                            .then(function(data){
                                                $scope.isDeleteloading = false;
                                                if(data['stat'])
                                                {
                                                    
                                                }else
                                                {
                                                    $mdToast.show(
                                                        $mdToast.simple()
                                                            .content(Translate.translateByObject(parentScope.Translate.PRODUCT.TYPE_WARNING,{COUNT:data['catCount'],TYPE:$scope.typeTitle}))
                                                            .position('top center')
                                                            .action(parentScope.Translate.DELETE_ALL)
                                                            .hideDelay(12000)
                                                            .theme('red')
                                                    ).then(function(){  /* Delete All Button Click */
                                                            $scope.isDeleteloading = true;
                                                            ProductFactory.deleteProductType(
                                                            {
                                                                id           :$scope.id,
                                                                force        :1
                                                            }).then(function(data){
                                                                $scope.isDeleteloading = false;
                                                                $mdToast.show(
                                                                    $mdToast.simple()
                                                                    .content(parentScope.Translate.PRODUCT.TYPE_DELETED)
                                                                    .position('top center')
                                                                    .hideDelay(4000)
                                                                    .theme('green')
                                                                );
                                                            },function(){
                                                                $scope.isDeleteloading = false;
                                                                $mdToast.show(
                                                                    $mdToast.simple()
                                                                    .content(parentScope.Translate.PRODUCT.TYPE_DELETED_ERROR)
                                                                    .position('top center')
                                                                    .hideDelay(4000)
                                                                    .theme('red')
                                                                );
                                                            });
                                                    });; 
                                                } 
                                            },function(data){});
                                            
                                        }
                                        
                                        $scope.onSearchableChange = function(item)
                                        {
                                            searchableField  = 0;
                                            for(j=0;j<$scope.dynamicFields.length;j++)
                                                for(k=0;k<$scope.dynamicFields[j].field.length;k++)
                                                    if($scope.dynamicFields[j].field[k]['model']['searchable'])
                                                        searchableField++;
                                            
                                            /* check max of searchable field */
                                            if(searchableField >  window.appConfig.maxSearchableField)
                                            {
                                                $mdToast.show(
                                                    $mdToast.simple()
                                                        .content(Translate.translateByObject(parentScope.Translate.PRODUCT.TYPE_SEARCHABLE_MAX_FIELD,{COUNT:window.appConfig.maxSearchableField}))
                                                        .position('top center')
                                                        .hideDelay(6000)
                                                        .theme('red')
                                                );
                                            
                                                item['searchable'] = false;
                                                searchableField--;
                                                return false;
                                            }
                                        }
                                        

                                        // Sortable dynamic field options
                                        $scope.dynamicFieldSortableOptions = {
                                                accept      : function (sourceItemHandleScope, destSortableScope) {
                                                                return true;
                                                },
                                                orderChanged: function(data){
                                                    // sort array
                                                    for(g=0; g < $scope.dynamicFields.length;g++)
                                                    {
                                                        fieldPriorityArray = [];
                                                        for(i=0;i < $scope.dynamicFields[g].field.length;i++)
                                                            if($scope.dynamicFields[g].field[i].model['priority'])
                                                                fieldPriorityArray.push(parseInt($scope.dynamicFields[g].field[i].model['priority']));
                                                        /*fieldSortedArray   = fieldPriorityArray.sort(function(a, b){return b-a});*/
                                                        fieldSortedArray   = fieldPriorityArray.sort();

                                                        for(i=0;i < $scope.dynamicFields[g].field.length;i++)
                                                            if(fieldSortedArray[i])
                                                                $scope.dynamicFields[g].field[i].model['priority'] = fieldSortedArray[i];
                                                    }
                                                    return true;
                                                },
                                                itemMoved   : function (data) {
                                                    var movedItem        =   data.source.itemScope.item;
                                                    var fieldset         =   data.dest.sortableScope.$parent.fieldset;
                                                    if(movedItem.model.fieldset_id){
                                                        movedItem.model.fieldset_id = fieldset.id;
                                                        this.orderChanged({});
                                                    }
                                                    return true;
                                                }
                                        };
    
    
    
}]);
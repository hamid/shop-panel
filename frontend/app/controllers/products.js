/* Products Controller */

mainApp.controller('ProductsCtrl', ['$scope', '$http','Translate','ProductFactory','$mdDialog','$mdToast',
function ($scope, $http, Translate,ProductFactory,$mdDialog,$mdToast) {
    
   /* Translation Setup,fill $scope with language words */
      Translate.getTranslation($scope,appConfig.language);
     
   /* ------------ Initialize ------------ */
        ProductFactory.init($scope,$http);
      
        $scope.boxList            = [];
        ProductFactory.makeBox(    {id:0}  ); // make root category
      
      
  /* ------------  Event Function  ------------ */
    $scope.itemClick   = function(box,item){
          
            for(var i=0; box.itemList[i]; i++)
                box.itemList[i].selected = false;
            item.selected     = true;
            item.loadingState = 'active';

            if(box.type == 'category')
            {
                ProductFactory.removeNextBox(box);
                ProductFactory.makeBox(item,function(){
                    item.loadingState = 'deActive';
                });
            }else if((box.type == 'product'))
            {
            }  
    }
      
/* --------- Sortable/DragDrop Events for Categories --------- */
    $scope.CategorySortableOptions = {
            accept      : function (sourceItemHandleScope, destSortableScope) {
                            return true;
            },
            orderChanged: function(data){  
                            var sortedList       = data.dest.sortableScope.modelValue;
                            return ProductFactory.sortItems(sortedList,'category');   
            },
            itemMoved   : function (data) {
                            var movedItem        =   data.source.itemScope.item;
                            var box              =   data.dest.sortableScope.$parent.box;
                            var sortedList       =   data.dest.sortableScope.modelValue;

                            ProductFactory.changeCategoryParent(movedItem.id,box.catid)
                                .success(function(data, status, headers, config)
                                {
                                    movedItem.parent_id = box.catid; /* frontend Update */
                                    return ProductFactory.sortItems(sortedList,'category');
                                })
                                .error(function(){alert('Error in changeCategoryParent | product ctrl')})
            }
    };
        
/* --------- Sortable/DragDrop Events for Products --------- */
    $scope.ProductSortableOptions = {
            accept      : function (sourceItemHandleScope, destSortableScope) {
                            return true;
            },
            orderChanged: function(data){  
                            var    sortedList = data.dest.sortableScope.modelValue;
                            return ProductFactory.sortItems(sortedList,'product');   
            },
            itemMoved   : function (eventObj) {
                            /*moveFailure*/
                            eventObj.dest.sortableScope.removeItem(eventObj.dest.index);
                            eventObj.source.itemScope.sortableScope.insertItem(eventObj.source.index, eventObj.source.itemScope.item);
                            $mdToast.show(
                                $mdToast.simple()
                                    .content($scope.Translate.PRODUCT.CAN_NOT_DROP_PRODUCT)
                                    .position('top center')
                                    .hideDelay(3000)
                            );     
            }
    };
        
    $scope.addCategoryDialog   = function(box,event)
    {
            ProductFactory.getProductType()
                .then(function(data){
                      $scope.typesList = data;
                });
            ProductFactory.getAccessList()
                .then(function(data){
                      $scope.accessList = data;
                });
                          
            $mdDialog.show({
                controller      :   function($scope,parentScope,ProductFactory) {
                                        
                                        $scope.parent        = parentScope;
                                        /* ------------ Initialize ------------ */
                                        ProductFactory.init(parentScope,$http);
                                        
                                        $scope.closeDialog   = function() {
                                            $mdDialog.cancel();
                                            return false;
                                        };
                                        $scope.addCat = function(form) {
                                            ProductFactory.addCategory(
                                                {
                                                    title       :$scope.catTitle,
                                                    type        :$scope.catType,
                                                    categoryid  :box.catid,
                                                    access      :$scope.accessList
                                                },
                                                box
                                            ).then(function(data){
                                                    $mdToast.show(
                                                        $mdToast.simple()
                                                            .content(parentScope.Translate.PRODUCT.CAN_NOT_DROP_PRODUCT)
                                                            .position('top center')
                                                            .hideDelay(4000)
                                                    );
                                            });
                                            $mdDialog.hide();  
                                        };/* end addCat  */
                                    },/* end Controller */
                templateUrl     :   'app/view/product/dialogs/addCategoryDialog.html?v1000',
                locals          :   {parentScope: $scope},
                targetEvent     :   event
            });
    }
    
      
      
    
      
    $scope.delete = function(box,item){
            pos > -1 && box.itemList.splice( pos, 1 );
    } 
      
      

  }]);
  
  
  
  

/* Products Controller */

mainApp.controller('ProductsCtrl', ['$scope', '$http','Translate','ProductFactory','$mdDialog','$mdToast',
function ($scope, $http, Translate,ProductFactory,$mdDialog,$mdToast) {
    
   /* Translation Setup,fill $scope with language words */
      Translate.getTranslation($scope,appConfig.language);
     
   /* ------------ Initialize ------------ */
        ProductFactory.init($scope,$http);
      
        $scope.boxList            = [];
        $scope.typesList          = [];
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
                                .success(function(output, status, headers, config)
                                {
                                    if(output.data)
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
/* --------------------- Add/Edit Ctegory --------------------- */        
    $scope.addCategoryDialog   = function(box,event){
        $scope.categoryDialog(box,'add',{},event);
    }
    $scope.editCategoryDialog   = function(box,item,event){
        $scope.categoryDialog(box,'edit',item,event);
        // prevent from bubbling
        if (event.stopPropagation) event.stopPropagation();
        if (event.preventDefault)  event.preventDefault();
    }
    
    
    $scope.categoryDialog   = function(box,mode,item,event)
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
                controller      :   'categoryDialog',
                templateUrl     :   'app/view/product/dialogs/categoryDialog.html?v1.001',
                locals          :   {
                                        parentScope : $scope,
                                        mode        : mode,
                                        item        : item,
                                        box         :box
                                    },
                clickOutsideToClose: true,
                targetEvent     :   event
            });
    }
    
/* --------------------- Delete Category --------------------- */       
    $scope.deleteCategoryDialog   = function(box,category,$event)
    {
        var confirm = $mdDialog.confirm()
            .title($scope.Translate.PRODUCT.CAT_DELETE_TITLE_DIALOG)
            .content(Translate.translateByObject($scope.Translate.PRODUCT.CAT_DELETE_QUESTION_DIALOG,{CAT:category.title}))
            .ariaLabel(' ')
            .ok($scope.Translate.DELETE)
            .cancel($scope.Translate.CLOSE)
            .theme('red')
            .targetEvent($event);
        // On delete button click on dialog
        $mdDialog.show(confirm).then(function() {
            ProductFactory.deleteCategory(category,box)
                .then(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content(Translate.translateByObject($scope.Translate.PRODUCT.CAT_DELETED,{CAT:category.title}))
                            .position('top center')
                            .hideDelay(4000)
                    );
                },function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content($scope.Translate.PRODUCT.CAT_NOT_DELETED)
                            .position('top center')
                            .hideDelay(4000)
                    );
                });
                
        }, function() {// On Close
        });
        // prevent from bubbling
        if ($event.stopPropagation) $event.stopPropagation();
        if ($event.preventDefault) $event.preventDefault();
    }
    
/* ----------------------- Type Dialog ----------------------- */     
    $scope.typeDialog   = function(mode,event,callback)
    {
            ProductFactory.getProductType()
                .then(function(data){
                      $scope.typesList = data;
                });

                          
            $mdDialog.show({
                controller      :   'typeDialog',
                templateUrl     :   'app/view/product/dialogs/typeDialog.html?v1.002',
                locals          :   {
                                        parentScope : $scope,
                                        mode        : mode,
                                        callback    : callback,
                                        event       : event
                                    },
                targetEvent     :   event,
                clickOutsideToClose: true
            });
    }
    
/* ----------------------- Product Dialog ----------------------- */      
    $scope.productDialog = function(box,mode,event,product){
         item = false;
         
         $mdDialog.show({
                controller      :   'productDialog',
                templateUrl     :   'app/view/product/dialogs/productDialog.html?v1.003',
                locals          :   {
                                        parentScope : $scope,
                                        box         : box,
                                        mode        : mode,
                                        event       : event,
                                        product     : product
                                    },
                clickOutsideToClose: true,
                targetEvent     :   event
            });
        
    }
    
    $scope.editProduct   = function(box,product,event)
    {
        product.loadingState = 'active colored';
        ProductFactory.getProductData(product)
            .then(function(productData){
                $scope.productDialog(box,'edit',event,productData);
                product.loadingState = 'deActive';
            });
    }
    
    $scope.deleteProduct     = function(box,item,$event)
    {
        var confirm = $mdDialog.confirm()
            .title($scope.Translate.PRODUCT.PRODUCT_DELETE_TITLE_DIALOG)
            .content(Translate.translateByObject($scope.Translate.PRODUCT.PRODUCT_DELETE_QUESTION_DIALOG,{PRODUCT:item.title}))
            .ariaLabel(' ')
            .ok($scope.Translate.DELETE)
            .cancel($scope.Translate.CLOSE)
            .theme('red')
            .targetEvent($event);
         // On delete button click on dialog
        $mdDialog.show(confirm).then(function() {
            ProductFactory.deleteProduct(item,box)
            .then(function(productData){
                $mdToast.show(
                    $mdToast.simple()
                        .content($scope.Translate.PRODUCT.PRODUCT_DELETED)
                        .position('top center')
                        .hideDelay(6000)
                        .theme('green')
                );
                $mdDialog.cancel();
            });
                
        }, function() {// On Close
        });
        
    }
      
      
    
      
    $scope.delete = function(box,item){
            pos > -1 && box.itemList.splice( pos, 1 );
    } 
      
      

  }]);
  
  
  
  

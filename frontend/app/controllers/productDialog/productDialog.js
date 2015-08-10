mainApp.controller('productDialog', ['$scope', 'parentScope','ProductFactory','box','mode','event','product','$http','$mdDialog','$mdToast',
function ($scope,parentScope,ProductFactory,box,mode,event,product,$http,$mdDialog, $mdToast) {
    
     
    $scope.parent        = parentScope;
    $scope.mode          = mode;

    /*-- Default Value --*/
    $scope.form  = {
        stat      : 1,
        visibility: 1,
        extraDescription:"",
        images:[],
    };
    $scope.extra = {};

    /*-- get product type title */
    ProductFactory.getProductType().then(function(data){
        $scope.typeTitle = box.getTypeName();
        /*-- get product fields --*/
        ProductFactory.getProductTypeByid(box.type_id)
            .then(function(item,data)
            {
                if(product && mode == 'edit') /*-- put value of type Field if is in edit mode --*/
                    item.fieldset = ProductFactory.fillProductTypeFieldsByValue(item.fieldset,product.typeFields)

                $scope.form.dynamicProductFields = item.fieldset; 
            })
    });
    ProductFactory.getAccessList()
        .then(function(data){
              $scope.accessList = data;
        });

    /* ---- Edit Mode ---- */
    if(product && mode == 'edit')
    {
        angular.extend($scope.form, product);
        /* put Product Image */
        $scope.extra.images = [];
        var newImage = {
                address : product.mainImages,
                src     : product.mainImagesUrl,
                complete: true,
                editMode: true,
            };
        $scope.extra.images.push(newImage);
        if(product.images)
        for(i=0;i<product.images.length; i++)
            $scope.extra.images.push({
                id      : product.images[i]['id'],
                address : product.images[i]['address'],
                src     : product.images[i]['url'],
                complete: true,
                editMode: true,
            });
    }
    /* ------------ Initialize ------------ */
    ProductFactory.init(parentScope,$http);

    $scope.closeDialog      = function() {
        $mdDialog.cancel();
        return false;
    };



    /*-- Upload images Tab --*/
    $scope.$watch('extra.images', function (files) {
        $scope.formUpload = false;
        if (files != null) {
            for (var i = 0; i < files.length; i++)
            {
                $scope.errorMsg = null;
                if(files[i]['complete'])
                    continue;
                (function (file) {
                    ProductFactory.upload(file)
                        .then(function(item){
                            if(item.data.path)
                                file.address = item.data.path;
                        })
                })(files[i]);
            }
        }
    });
    $scope.deleteImg            = function(img){
        var imgIndex       = $scope.extra.images.indexOf(img);
        $scope.extra.images.splice(imgIndex,1);
    }
    /*-- Sortable Image --*/
    $scope.imageSortableOptions = {
            accept      : function (sourceItemHandleScope, destSortableScope) {return true;},
            orderChanged: function(data){return true;}
    };
    /* Submit Form */
    $scope.submitProductForm = function(productForm)
    {
        if($scope.mode == 'add')
            return $scope.addProduct(productForm);
        return $scope.editProduct(productForm);
    }

    __mkImageData = function(){
        console.log($scope.extra.images);
        if($scope.extra.images)
            for(i=0;i<$scope.extra.images.length;i++)
            {
                if(i==0)
                {
                    $scope.form.mainImages =  {
                        name    :$scope.extra.images[0]['name'],
                        address :$scope.extra.images[0]['address']
                    }
                    continue;
                }
                $scope.form.images.push({
                    name    :$scope.extra.images[i]['name'],
                    id      :$scope.extra.images[i]['id'],
                    address :$scope.extra.images[i]['address']
                });
            }
    }

    $scope.addProduct        = function(productForm)
    {
        $scope.form.images = [];
        __mkImageData();/*--- Fix Product Images ---*/
        $scope.isAddloading = true;
        ProductFactory.addProduct($scope.form,box)
            .then(function(productData){
                $mdToast.show(
                    $mdToast.simple()
                        .content(parentScope.Translate.PRODUCT.PRODUCT_ADDED)
                        .position('top center')
                        .hideDelay(6000)
                        .theme('green')
                );
                $scope.isAddloading = false;
                $mdDialog.cancel();
            });
    }

    $scope.editProduct       = function(productForm)
    {
        $scope.form.images = [];
        __mkImageData();/*--- Fix Product Images ---*/
        $scope.isEditloading = true;
        ProductFactory.editProduct(product,$scope.form,box)
            .then(function(productData){
                    $mdToast.show(
                        $mdToast.simple()
                            .content(parentScope.Translate.PRODUCT.PRODUCT_EDITED)
                            .position('top center')
                            .hideDelay(6000)
                            .theme('green')
                    );
                    $scope.isEditloading = false;
                    $mdDialog.cancel();
                });
    }



    
    
}]);
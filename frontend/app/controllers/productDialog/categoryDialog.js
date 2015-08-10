mainApp.controller('categoryDialog', ['$scope', 'parentScope','ProductFactory','mode','item','$http','box','$mdDialog','$mdToast',
function ($scope,parentScope,ProductFactory,mode,item,$http,box,$mdDialog, $mdToast) {
    $scope.parent        = parentScope;
    $scope.mode          = mode;
    if(item)
    {
        $scope.id           = item.id;
        $scope.catTitle     = item.title;
        $scope.catType      = item.type_id;
        $scope.accessList   = item.access;
    }
    /* ------------ Initialize ------------ */
    ProductFactory.init(parentScope,$http);

    $scope.closeDialog   = function() {
        $mdDialog.cancel();
        return false;
    };
    $scope.showTypeDialog = function($event){

        $scope.parent.typeDialog('add',$event,function(data){
            if(data && data['id'])
                var type_id = data['id'];
            else
                var type_id = $scope.catType;

            $scope.parent.categoryDialog(box,mode,{'title':$scope.catTitle,'type_id':type_id,'access':$scope.accessList},event);
        });
    }

    $scope.submitCatForm = function(catForm)
    {
        if($scope.mode == 'add')
            return $scope.addCat(catForm);
        return $scope.editCat(catForm);
    }

    $scope.editCat = function(form) {
        ProductFactory.editCategory(
            {
                id          :$scope.id,
                title       :$scope.catTitle,
                type_id     :$scope.catType,
                categoryid  :box.catid,
                access      :$scope.accessList
            },
            box
        ).then(function(data){ 
            $mdToast.show(
                $mdToast.simple()
                    .content(parentScope.Translate.PRODUCT.CAT_EDITED)
                    .position('top center')
                    .hideDelay(4000)
            );   
        },function(){
            $mdToast.show(
                    $mdToast.simple()
                        .content(parentScope.Translate.PRODUCT.CAT_NOT_EDITED)
                        .position('top center')
                        .hideDelay(4000)
                        .theme('red')
            );
        });
        $mdDialog.hide();  
    };/* end addCat  */

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
                    .content(parentScope.Translate.PRODUCT.CAT_ADDED)
                    .position('top center')
                    .hideDelay(4000)
            );   
        },function(){
            $mdToast.show(
                    $mdToast.simple()
                        .content(parentScope.Translate.PRODUCT.CAT_NOT_ADDED)
                        .position('top center')
                        .hideDelay(4000)
                        .theme('red')
            );
        });
        $mdDialog.hide();  
    };/* end addCat  */

    
    
}]);
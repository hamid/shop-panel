
/**
* ProductFactory object
* the object contains functions work with products 
* its connected to Product Controller
*/
  
  
var ProductService = angular.module('ProductFactory', ['ngResource']);    
    ProductService.factory('ProductFactory', ['$resource','$http','$q',
  function($resource,$http,$q){
      
   
      
   return  {
    
 /* scope of controller used in view */
    $scope          : false,
    
 /* $http of controller used in communication with the remote  */
    $http           : $http,
 /* $http of controller used in communication with the remote  */
    productTypes    : [],
    

    
    
/*--------------------[ M E T H O D S ]--------------------*/
    
    init:function($scope,$http)
    {
       this.$scope   = $scope;
       this.$http    = $http;
    },
    
    
    
    makeBox:function(item,callback)
    {
        if(this.getCatChildrenType(item) == 'category')
        {
            var url         = '/product/getCatList';
            var dataType    = 'category';
        }else
        {
            var url         = '/product/getProductList';
            var dataType    = 'product';
        }
        var parentid = item.id;
        var selfFactory = this;
        
        /* fetch data */
        this.ajax(url,{catid:parentid}).success(function(data, status, headers, config) {
            boxObject   = {
                boxid       : selfFactory.$scope.boxList.length,
                catid       : parentid,
                itemList    : data,
                type        : dataType,
            };
            selfFactory.$scope.boxList.push(boxObject);
            if(typeof callback == 'function')
                callback(data, status, headers, config);
        }).
        error(function(){alert('Error in fetch data | product ctrl')});
        
    },
    
    
    /**
     * ProductHelper.sortItems()
     *  sort items in each box
     *  this method make an array contains objects of  
     *      `id`        the id of item 
     *      `priority`  the priority of item
     * by given sorted item List as parameter
     * and then sends array to backend to update  sorted list
     * 
     * @param  array itemList :  new sorted item list of one box 
     * @return boolean   
     */
    sortItems:function(itemList,type)
    {
        if(!type) alert('Error: Type is not set');
        
        var orderList   = {};
        for(i in itemList)
            orderList[i] = {
                id        :itemList[i].id,
                priority  :i
            };
        if(type == 'category')
        {
            var params = {
                list     :orderList,
                parentId :itemList[i]['parent_id']
            };
            return this.ajax('/product/sortCategories',params);
        }
        else if(type == 'products')
        {
            var params = {
                list     :orderList,
                parentId :itemList[i]['cat']
            };
            return this.ajax('/product/sortProducts',params);
        }
        
    },
    
    
    /**
     * ProductHelper.changeCategoryParent()
     *  change parent id of given category to given new parent id
     * 
     * @param  int      itemId      :  id of category should be update 
     * @param  int      newParentId :  new id of new parent 
     * @param  function callback    :  a function run after 
     * @return object $http angular service, it has success and error callbacks
     *         to achive ajax response   
     */
    changeCategoryParent:function(itemId,newParentId)
    {
        var params = {
            itemId      :itemId,
            newParentId :newParentId
        };
        return this.ajax('/product/changeCategoryParent',params)
    },
    
    
    /**
     * ProductHelper.getCatChildrenType()
     *  return  type of category children
     *  the children could be `product` or `category`
     * 
     * @param  int item
     * @return string   
     */
    getCatChildrenType:function(item)
    {
        if(item['type_id'] && item['type_id'] !="0")
            return 'product';
        return 'category';
    },
    
  
    
    
    /**
     * ProductHelper.removeNextBox()
     *   remove boxes after specific box index
     *   it's used when the item of previous box was clicked , so the next boxes
     *   should be removed
     * 
     * @param object box     
     */
    removeNextBox:function(box)
    {
        var baseBoxIndex    = this.$scope.boxList.indexOf(box);
        this.$scope.boxList = this.$scope.boxList.slice(0,baseBoxIndex+1);
    },
    
    /**
     * ProductHelper.getProductType()
     *   Get All Product Types 
     * 
     * @param array list : list that should fill     
     */
    getProductType:function(list,func)
    {
        var deferred        = $q.defer();
        selfFactory         = this;
        
        if(this.productTypes.length){
            deferred.resolve(this.productTypes);
        } 
        
        this.ajax('/product/getProductType',{}).success(function(data, status, headers, config) {
            if(data){
                selfFactory.productTypes  = data;
                deferred.resolve(data);
            }
        }).
        error(function(){deferred.reject(data);alert('Error in changeCategoryParent | product factory')});

        return deferred.promise;
          
    },
    
    
    
    
    /**
     * ProductHelper.ajax()
     *   function for Post request , it uses $http angular service
     * 
     * @param string url     url of post request
     * @param object params  object of parameters to send 
     * @return object $http angular service, it has success and error callbacks
     *         to achive ajax response
     */
    ajax:function(url,params){
        return this.$http(
        {
            method          : 'POST',
            url             : window.appConfig.urlPrefix+url,
            data            : params,
            /*
             *  NOTE: Because our backend doesnt support Content-Type: application/json,
             *        so we need to transmits data using Content-Type: x-www-form-urlencoded
             *        and the familiar foo=bar&baz=moe serialization.
             *        angular uses application/json
            */
            headers         : {'Content-Type': 'application/x-www-form-urlencoded'},
            transformRequest: function(obj) {
                return $.param(obj)
            }
        });
    }
    
  };

  }]);    


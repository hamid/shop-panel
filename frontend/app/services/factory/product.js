
/**
|--------------------------------------------------------------------------
| ProductFactory object
|--------------------------------------------------------------------------
| the object contains functions work with products 
| its connected to Product Controller
| Service Name : Translate
*/
  
  
var ProductService = angular.module('ProductFactory', ['ngResource']);    
    ProductService.factory('ProductFactory', ['$resource','$http','$q','Upload',
  function($resource,$http,$q,Upload){
      
   
      
   return  {
    
 /* scope of controller used in view */
    $scope          : false,
    
 /* $http of controller used in communication with the remote  */
    $http           : $http,
 /* $http of controller used in communication with the remote  */
    productTypes    : [],
    accessList      : [],
    

    
    
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
        var parentid        = item.id;
        var selfFactory     = this;
        /* fetch data */
        this.ajax(url,{catid:parentid}).success(function(output, status, headers, config) {
            boxObject = new selfFactory.box({
                boxid       : selfFactory.$scope.boxList.length,
                catid       : parentid,
                itemList    : output.data,
                type        : dataType,
                type_id     : item['type_id'],
                $scope      : selfFactory.$scope,
            });
            selfFactory.$scope.boxList.push(boxObject);
            if(typeof callback == 'function')
                callback(output, status, headers, config);
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
     * ProductHelper.getAccessList()
     *   Get All access List 
     *   `public`  options with value of 0 is invariant
     *    
     * @return object  defer  
     */
    getAccessList:function()
    {
        var deferred        = $q.defer();
        selfFactory         = this;
        
        if(this.accessList.length){
            deferred.resolve(this.accessList);
        } 
        
        this.ajax('/product/getAccessList',{}).success(function(output, status, headers, config) {
            if(output.data){
                selfFactory.accessList  = output.data;
                deferred.resolve(output.data);
            }
        }).
        error(function(){deferred.reject(data);alert('Error in getAccessList | product factory')});

        return deferred.promise;
          
    },
    /**
     * ProductHelper.addCategory()
     *   add new Category 
     * 
     * @param  object  catDataObj : object of all input data to add category
     * @param  object  box object : the object that category should be in
     * 
     * @return object  defer   
     */
    addCategory:function(catDataObj,box)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        var ajaxInput       = {
            title       :catDataObj.title,
            type        :catDataObj.type,
            access      :catDataObj.access,
            categoryid  :catDataObj.categoryid,
        };
        var __self = this;
        this.ajax('/product/addCategory',ajaxInput).success(function(output, status, headers, config) {
            if(output.data){
                box.addItem(output.data);
                deferred.resolve(output.data);
            }else
                 deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in addCategory | product factory')
        });

        return deferred.promise; 
    },
    
    /**
     * ProductHelper.editCategory()
     *   edit given Category 
     * 
     * @param  object  catDataObj : object of all input data to add category
     * @param  object  box object : the object that category should be in
     * 
     * @return object  defer   
     */
    editCategory:function(category,box)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        
        if(!category.id)
            deferred.reject(false);
        
        var ajaxInput       = {
            '_METHOD'   :'PUT',
            title       :category.title,
            type        :category.type_id,
            access      :category.access,
            categoryid  :category.categoryid,
        };
        var __self = this;
        this.ajax('/product/editCategory/'+category.id, ajaxInput).success(function(output, status, headers, config) {
            if(output.data){
                box.editItem(category);
                deferred.resolve(output.data);
            }else
                 deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in editCategory | product factory')
        });

        return deferred.promise; 
    },
    
    
    
    
    /**
     * ProductHelper.deleteCategory()
     *   delete given Category 
     * 
     * @param  object  category   : category that should be delete
     * @param  object  box object : the box that category should delete from it
     * 
     * @return object  defer   
     */
    deleteCategory:function(category,box)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        
        if(!category.id)
            deferred.reject(false);
        
        var ajaxInput       = {
            '_METHOD'       :'DELETE',
        };
        var __self = this;
        this.ajax('/product/deleteCategory/'+category.id,ajaxInput).success(function(output, status, headers, config) {
            if(output.data){
                box.deleteItem(category);
                deferred.resolve(output.data);
            }else
                deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in deleteCategory | product factory')
        });

        return deferred.promise; 
    },
    
    
    
    /**
     * ProductHelper.getProductType()
     *   Get All Product Types List ,contain `title`
     * 
     * @param array list : list that should fill     
     */
    getProductType:function(list)
    {
        var deferred        = $q.defer();
        selfFactory         = this;
        
        if(this.productTypes.length){
            deferred.resolve(this.productTypes);
        } 
        
        this.ajax('/product/getProductType',{}).success(function(output, status, headers, config) {
            if(output.data){
                selfFactory.$scope.typesList = output.data;
                deferred.resolve(output.data);
            }
        }).
        error(function(){deferred.reject(data);alert('Error in getProductType | product factory')});

        return deferred.promise;
          
    },
    /**
     * ProductHelper.addProductType()
     *   add Type 
     * 
     * @param  object  inputData   : object of all input data to add Type 
     *                              contain `title` , `fields`
     * 
     * @return object  defer   
     */
    addProductType:function(inputData)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        var ajaxInput       = {
            title       :inputData.title,
            fields      :inputData.fields,
        };
        var __self = this;
        this.ajax('/product/addProductType',ajaxInput).success(function(output, status, headers, config) {
            if(output.data){
                __self.$scope.typesList.push(output.data);
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in addType | product factory')
        });

        return deferred.promise; 
    },
    
    
    /**
     * ProductHelper.editProductType()
     *   edit Type 
     * 
     * @param  object  inputData   : object of all input data to edit Type 
     *                              contain `id` ,`title` ,`fields`
     * 
     * @return object  defer   
     */
    editProductType:function(inputData,productType)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        var ajaxInput       = {
            '_METHOD'       :'PUT',
            id              :inputData.id,
            title           :inputData.title,
            fields          :inputData.fields,
            deletedfieldsets:inputData.deletedfieldsets,
            deletedfields   :inputData.deletedfields,
        };
        var __self = this;
        this.ajax('/product/editProductType/'+inputData.id,ajaxInput).success(function(output, status, headers, config) {
            if(output.data)
            {
                /* - Update Type product in $scope - */
                for(i=0;i<__self.$scope.typesList.length;i++)
                    if(__self.$scope.typesList[i]['id'] == inputData.id)
                        __self.$scope.typesList[i]['title'] = inputData.title;
                
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in editType | product factory')
        });

        return deferred.promise; 
    },
    
    
   /**
     * ProductHelper.deleteProductType()
     *   delete Type 
     * 
     * @param  object  inputData   : object of all input data to edit Type 
     *                              contain `id` ,`title` ,`fields`
     * 
     * @return object  defer   
     */
    deleteProductType:function(inputData,productType)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        var ajaxInput       = {
            '_METHOD'    :'DELETE',
            id           :inputData.id,
            force        :inputData.force
        };
        var __self = this;
        this.ajax('/product/deleteProductType/'+inputData.id,ajaxInput).success(function(output, status, headers, config) {
            if(output.data)
            {
                /* - Delete Type product in $scope - */
                if(output.data && inputData.force)
                    for(i=0;i<__self.$scope.typesList.length;i++)
                        if(__self.$scope.typesList[i]['id'] == inputData.id)
                            delete __self.$scope.typesList[i]['title'];
                
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in DeleteType | product factory')
        });

        return deferred.promise; 
    },
    
    
    
    /**
     * ProductHelper.getProductTypeByid()
     *   get fields of Product Type by given its id 
     * 
     * @param  int  typeid   : id of type
     * 
     * @return object  defer   
     */
    getProductTypeByid:function(typeid)
    {
        var selfFactory     = this;
        var deferred        = $q.defer();
        var __self = this;
        this.ajax('/product/getProductTypeByid/'+typeid,{}).success(function(output, status, headers, config) {         
            if(output.data)
            {
                i = 0;
                /* add Fields to its type */
                if(selfFactory.$scope.typesList.length < 1)
                    selfFactory.$scope.typesList.push({
                        id      :typeid,
                        fieldset:output.data
                    })
                else
                    for(i=0;i<selfFactory.$scope.typesList.length ; i++)
                        if(selfFactory.$scope.typesList[i].id == typeid){
                            selfFactory.$scope.typesList[i].fieldset = output.data
                            break;
                        }
                deferred.resolve(selfFactory.$scope.typesList[i],output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            deferred.reject(false);
            alert('Error in getProductTypeByid | product factory')
        });

        return deferred.promise; 
    },
    
     /**
     * ProductHelper.fillProductTypeFieldsByValue()
     *   fill ProductTypeFields By given array of fieldset with value
     * 
     * @param  array  fieldsets   : array of fieldsets and fields
     * @param  array  values      : array of fieldsets and fields  with their value
     * 
     * @return array  fieldsets   
     */
    fillProductTypeFieldsByValue:function(fieldsets,values)
    {
        var keyValObj = {};
        for(i=0;i<values.length;i++)
            for(g=0;g<values[i]['fields']['length'];g++)
                keyValObj[values[i]['fields'][g]['field_id']] = 
                {
                    'value'     : values[i]['fields'][g]['value'],
                    'value_id'  : values[i]['fields'][g]['id']
                };
        
        for(i=0;i<fieldsets.length;i++)
            for(g=0;g<fieldsets[i]['fields']['length'];g++)
            {
                fieldsets[i]['fields'][g]['model']    = keyValObj[   fieldsets[i]['fields'][g]['id']   ]['value'];
                fieldsets[i]['fields'][g]['value_id'] = keyValObj[   fieldsets[i]['fields'][g]['id']   ]['value_id'];
            }
        return fieldsets;
    },
    
    
    
    
    /**
     * ProductHelper.upload()
     *   upload image(s) 
     * 
     * @param  obj  file   
     * 
     * @return object  defer   
     */
    upload              :function(file)
    {
        var deferred = $q.defer();
        
        file.upload  = Upload.upload({
            url         : window.appConfig.urlPrefix+'/product/upload',
            method      : 'POST',
            file        : file,
            sendFieldsAs: 'form',
            
        });
        
        file.complete = false;
        file.upload.then(function (response) {
            file.result   = response.data;
            file.complete = true;
            return  deferred.resolve(response.data);
                
        }, function (response) {
            if (response.status > 0)
                file.errorMsg = response.status + ': ' + response.data;
            return deferred.reject(response);
        });

        file.upload.progress(function (evt) {
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
        
        return deferred.promise;
    },
    
    
    
    /**
     * ProductHelper.addProduct()
     *   add Product 
     * 
     * @param  obj  data   inputs and fields of product   
     * @param  obj  box    the box that product belongs to   
     * 
     * @return object  defer   
     */
    addProduct              :function(data,box)
    {
        var deferred = $q.defer();
        
        this.ajax('/product/addProduct/',{'data':data,catid:box.catid}).success(function(output, status, headers, config) {         
            if(output.data)
            {
                data.cat    = box.catid;
                data.class  = 'newItemAnimate'
                box.addItem(data);
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            alert('Error in addProduct | product factory')
            deferred.reject(false);
        });
       
        return deferred.promise;
    },
    
    /**
     * ProductHelper.getProductData()
     *   get data of the given product 
     * 
     * @param  obj  product   object of product item 
     * 
     * @return object  defer   
     */
    getProductData              :function(product)
    {
        var deferred = $q.defer();
        
        this.ajax('/product/getProductData/'+product.id,{'id':product.id}).success(function(output, status, headers, config) {         
            if(output.data)
            {
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            alert('Error in getProductData | product factory')
            deferred.reject(false);
        });
       
        return deferred.promise;
    },
    
    
    /**
     * ProductHelper.addProduct()
     *   add Product 
     * 
     * @param  obj  product the product should be edit   
     * @param  obj  data    inputs and fields of product   
     * @param  obj  box     the box that product belongs to   
     * 
     * @return object  defer   
    */
    editProduct              :function(product,data,box)
    {
        var deferred = $q.defer();
        
        this.ajax('/product/editProduct/'+product.id,{
            '_METHOD'   :'PUT',
            'data'      :data,
            'catid'     :box.catid,
        }).success(function(output, status, headers, config) {         
            if(output.data)
            {
                data.cat    = box.catid;
                data.class  = 'newItemAnimate'
                box.editItem(output.data);
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            alert('Error in editProduct | product factory')
            deferred.reject(false);
        });
       
        return deferred.promise;
    },
    
    /**
     * ProductHelper.deleteProduct()
     *   dfelete Product 
     * 
     * @param  obj  data   inputs and fields of product   
     * @param  obj  box    the box that product belongs to   
     * 
     * @return object  defer   
    */
    deleteProduct              :function(product,box)
    {
        var deferred = $q.defer();
        
        this.ajax('/product/deleteProduct/'+product.id,{
            '_METHOD'   :'DELETE',
        }).success(function(output, status, headers, config) {         
            if(output.data)
            {
                box.deleteItem(product);
                deferred.resolve(output.data);
            }
            else
                deferred.reject(output.data);
        })
        .error(function(){
            alert('Error in deleteProduct | product factory')
            deferred.reject(false);
        });
       
        return deferred.promise;
    },
    
    
    

          
/*------------------------------------------------------------*/    
/*---------------------- View Methods ------------------------*/
/*------------------------------------------------------------*/
    box:function(initialObj){
        this.boxid       = initialObj.boxid;
        this.catid       = initialObj.catid;    // or parent id
        this.itemList    = initialObj.itemList; // List of its categories or its Products
        this.type        = initialObj.type;
        this.type_id     = initialObj.type_id;
        this.$scope      = initialObj.$scope;
        
        
        /**
        * ProductHelper.box.addItem()
        *   add new Category in box at view
        * 
        * @param  object  dataObj : object of all input data to add category or product
        *  
        */
        this.addItem = function(dataObj){
            dataObj.class='newItemAnimate';
            this.itemList.push(dataObj);
        }
        
        /**
        * ProductHelper.box.deleteItem()
        *   remove given item from box
        * 
        * @param  object  item 
        *  
        */
        this.deleteItem = function(item){
            var baseItemIndex    = this.itemList.indexOf(item);
            this.itemList.splice(baseItemIndex,1);
        }
        
        /**
        * ProductHelper.box.editItem()
        *   edit propertis of item 
        * 
        * @param  object  item 
        *  
        */
        this.editItem = function(item){
            var baseItemIndex   = this.findItemIndexById(item.id);
            for(prop in item)
                this.itemList[baseItemIndex][prop]   = item[prop];
            this.itemList[baseItemIndex]['class'] = 'newItemAnimate';
        }
        
        /**
        * ProductHelper.box.findItemIndexById()
        *   find index of item by given its id
        * 
        * @param  int  id 
        * @return int  index of item in list     
        */
        this.findItemIndexById = function(id){
            for(i=0;i<this.itemList.length;i++)
                if(this.itemList[i]['id'] == id)
                    return i;
            return -1;
        }
        
        /**
        * ProductHelper.box.findItemIndexById()
        *   find index of item by given its id
        * 
        * @param  int  id 
        * @return int  index of item in list     
        */
        this.getTypeName = function(id){
            if(this.type_id == '') return '';
            for(i=0;i<this.$scope.typesList.length;i++)
                if(this.$scope.typesList[i]['id'] == this['type_id'])
                    return this.$scope.typesList[i]['title'];
        }

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


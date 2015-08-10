<?php

class EAV{
    
    public  static $DB;
    
    public  static $default_query_count     = 10;
    public  static $app_config;
    
    
   /**
   * EAV::setDriver()
   *    set database driver
   *    this driver should have query,fetch,loadInArray methods
   * 
   * @param object $DB object of database driver
   */
    public static function  setDriver($DB) {
        self::$DB = $DB;
    }

    
   /**
   * EAV::getCategoryListByParent()
   *    get list of categories(children) of specific category
   * 
   * @param int $parent_id number(id) category that method should return its 
   *            children, $parent_id = 0 means get root category.
   * @param array,string $fields array of require fields, default is *
   * @return array of category 
   */
    public static function getCategoryListByParent($parent_id = 0,$fields = '*')
    {
        $parentCategory   = new Category(array('id'=>$parent_id));
        $children         = $parentCategory->getChildren($fields);
        
        return $children;
    }
    
   /**
   * EAV::getCategoryListByParent()
   *    get list of categories(children) of specific category
   * 
   * @param int $parent_id number(id) category that method should return its 
   *            children, $parent_id = 0 means get root category.
   * @param array,string $fields array of require fields, default is *
   * @return array of category 
   */
    public static function getProductListByParent($parent_id = 0,$fields = '*')
    {
        $parentCategory   = new Category(array('id'=>$parent_id));
        $products         = $parentCategory->getProducts($fields);
        
        return $products;
    }

    
   /**
   * EAV::sortCategories()
   *    sort categories by array of id and its priority
   * 
   * @param array $sortedItems array of sorted catrgories that  has two key
   *        `id` and its `priority`
   * @param int $parent_id  parent id of items in $sortedItems
   * @return array of result 
   */
    public static function sortCategories($sortedItems,$parent_id)
    {
        if(!$parent_id && $parent_id !=0) return false;
        // load children of curent parent id
        $allowedCategoryObj     =   EAV::getCategoryListByParent($parent_id,array('id'));
        foreach($allowedCategoryObj as $item)
            $allowedCategory[$item->id]    = true;
        $sortedCat              =   array();
        
        if(is_array($sortedItems))
            foreach($sortedItems as $category)
            {
                if(!$allowedCategory[$category['id']])  break;
                if($sortedCat[$category['id']])         continue; 
                
                $cat   = new Category(  array('id'=>$category['id'])    );
                $cat->update(   array(
                                    'priority'=>intval( $category['priority'] )
                            ));
                $sortedCat[$category['id']]  = true;
            }
        return $sortedCat;  
    }

    
   /**
   * EAV::sortProducts()
   *    sort Products by array of id and its priority
   * 
   * @param array $sortedItems array of sorted products that  has two key
   *        `id` and its `priority`
   * @param int $parent_id  parent id of items in $sortedItems
   * @return array of result 
   */
    public static function sortProducts($sortedItems,$parent_id)
    {
//        if(!$parent_id && $parent_id !=0) return false;
//        // load children of curent parent id
//        $allowedCategoryObj     =   EAV::getCategoryListByParent($parent_id,array('id'));
//        foreach($allowedCategoryObj as $item)
//            $allowedCategory[$item->id]    = true;
//        $sortedCat              =   array();
//        
//        if(is_array($sortedItems))
//            foreach($sortedItems as $category)
//            {
//                if(!$allowedCategory[$category['id']])  break;
//                if($sortedCat[$category['id']])         continue; 
//                
//                $cat   = new Category(  array('id'=>$category['id'])    );
//                $cat->update(   array(
//                                    'priority'=>intval( $category['priority'] )
//                            ));
//                $sortedCat[$category['id']]  = true;
//            }
//        return $sortedCat;  
    }
    
    
    
    
   /**
   * EAV::changeCategoryParent()
   *    Change Category Parent id 
   * 
   * @param array $sortedItems array of sorted catrgories that  has two key
   *        `id` and its `priority`
   * @param int $parent_id  parent id of items in $sortedItems
   * @return array of result 
   */
    public static function changeCategoryParent($categoryId,$newParent_id)
    {
        $cat   = new Category(  array('id'=>$categoryId)    );
        return   $cat->update(  array(
                                    'parent_id'=>intval( $newParent_id )
                             ));
    }
    
    
    
   /**
   * EAV::getProductType()
   *    Get All Product Types
   * 
   * @return array of result 
   */
    public static function getProductTypes()
    {
        $res     = self::$DB->query('SELECT  *
                                    FROM    `product_type`
                                    WHERE   `id` != 0; ');
        /* Note: id = 0 means No Type , if a category has type with id =0 
         *       it means Type is not set for category
        */
        return  self::$DB->loadInArray($res);
    }
    
    
   /**
   * EAV::getAccessList()
   *    Get All access List
   * 
   * @return array of result 
   */
    public static function getAccessList()
    {
        return array();
    }
    
    
    
    
    
    
   /**
   * EAV::addCategory()
   *    add category 
   * 
   * @param string $name        name of category
   * @param int    $type        type id of category
   * @param int    $categoryid  category id (parent id)
   * @return array of result 
   */
    public static function addCategory($title,$type,$categoryid,$access)
    {
        $cat   = new Category(array(
                    'title'     => $title,
                    'type_id'   => $type,
                    'access'    => $access,
                    'parent_id' => $categoryid,
        ));
        return ($cat->save())? $cat : false ;
    }
    
    
    /**
   * EAV::editCategory()
   *    edit given category 
   * 
   * @param int    $id          id of category
   * @param string $name        name of category
   * @param int    $type        type id of category
   * @param int    $categoryid  category id (parent id)
   * @return boolen stat of result
   */
    public static function editCategory($id,$title,$type,$categoryid,$access)
    {
        $cat   = new Category(array(
                    'id'     => intval($id),
        ));
        
        $stat  = $cat->update(array(
                    'title'     => $title,
                    'type_id'   => $type,
                    'access'    => $access,
                    'parent_id' => $categoryid,
        ));
        return ($stat)? true : false ;
    }
    
    
    /**
   * EAV::deleteCategory()
   *    add category 
   * 
   * @param string $name        name of category
   * @param int    $type        type id of category
   * @param int    $categoryid  category id (parent id)
   * @return array of result 
   */
    public static function deleteCategory($id)
    {
        $cat   = new Category(array(
                    'id'     => $id,
        ));
        return $cat->delete();
    }

    
    
    
   /**
   * EAV::addProductType()
   *    add Type 
   * 
   * @param string $name        name of category
   * @param int    $type        type id of category
   * @param int    $categoryid  category id (parent id)
   * @return array of result 
   */
    public static function addProductType($title,$fields)
    {
        $type   = new Type(array(
                    'title'     => $title
        ));
        if($stat = $type->save())
        {
            foreach($fields as $fieldset)
            {
                $fieldset['id'] = $type->addFieldset($fieldset['title']);
                foreach($fieldset['field'] as $item)
                    $type->addField($fieldset['id'],$item['title'],$item['type'],$item['searchable'],$item['option']);
            }
           return $type;
        }
        return false;
    }
    
    
   /**
   * EAV::editProductType()
   *    edit Type 
   * 
   * @param int    $id          id of category
   * @param string $name        name of category
   * @param int    $type        type id of category
   * @param int    $categoryid  category id (parent id)
   * @return array of result 
   */
    public static function editProductType($id,$title,$fieldsets,$deletedfieldsets =array(),$deletedfields = array())
    {
        if(empty($id))
            return false;
        
        $type   = new Type(array(
                    'id'        => $id,
                    'title'     => $title
                ));
        
       //---Delete Fieldsets
        if(is_array($deletedfieldsets) && !empty($deletedfieldsets))
            foreach($deletedfieldsets as $fieldset_id)
                $stat = $type->deleteFieldset($fieldset_id);
       //---Delete Fields
        if(is_array($deletedfields) && !empty($deletedfields))
            foreach($deletedfields as $field_id)
                $stat = $type->deleteField($field_id);
        

            
                
       //--- Update Type
        $stat   = $type->update(array(
                    'title'     => $type->title
                ));
        
        
        foreach($fieldsets as $fieldset)
        {
            //--Count of searchable field
            $searchableCount = 0;
            if(is_array($fieldset['field']))
                foreach($fieldset['field'] as $field)
                    if($field['searchable'])
                        $searchableCount++;
            if($searchableCount > intval(EAV::$app_config['maxSearchableField']))
                return false;
            
            //--Update FieldSet
            if(isset($fieldset['id']) && !empty($fieldset['id']))
                $type->editFieldset($fieldset['id'],array(
                    'title'=>$fieldset['title']
                ));
            else
                $fieldset['id'] = $type->addFieldset($fieldset['title']);

            
           //--Update  Fields
            if(is_array($fieldset['field']))
                foreach($fieldset['field'] as $field)
                {
                    // if the fields has already added and need to EDIT
                    if(isset($field['id']) && !empty($field['id']))
                    {
                        if(empty($field['priority']))
                            $priority   = $field['id'];
                        else
                            $priority   = $field['priority'];


                        $stat = $type->editField(
                                    $field['id'],
                                    array(
                                        'title'       =>  $field['title'],
                                        'searchable'  =>  $field['searchable'],
                                        'fieldset_id' =>  $field['fieldset_id'],
                                        'options'     =>  $field['option'],
                                        'priority'    =>  $priority,
                                    )     
                                );
                    }else // if the field is new and need to ADD
                    {
                        $stat = $type->addField($fieldset['id'],$field['title'],$field['type'],$field['searchable'],$field['option']);
                    }
                }
        }// end foreach of fieldset
            
        return $stat;
        
        
    }
    
    
   /**
   * EAV::deleteProductType()
   *    first check that is there any category or product use it
   *    and then if force option is true  delete all of categories/ products and type
   * 
   * @param string  $id        id of type
   * @param boolean $force     delete even type is set for category and products
   * @return array of result   `stat` => stat of action ,`catCount` => count of category
   */
    public static function deleteProductType($id,$force = false)
    {
        $type   = new Type(array(
                    'id'     => $id
        ));
        
        
        if(!$force)
        {
            $catCount       =  $type->getCategoryCount();
            if($catCount > 0)
            {
                return array('stat'=>false,'catCount'=>$catCount);
            }
        }
        
        return $type->delete();
        
    }
    
    
   /**
   * EAV::getProductTypeByid()
   *    return fields  of product by given id 
   * 
   * @param string $id        id of type
   * @return array of result 
   */
    public static function getProductTypeByid($id)
    {
        $type   = new Type(array(
                    'id'     => $id
        ));
        return $type->getFieldsets(true);
    }
    
    
   /**
   * EAV::addProduct()
   *    add product 
   * 
   * @param string $data        fieds of product
   * @param int    $catid       product category id
   * @return array of result 
   */
    public static function addProduct($data,$catid)
    {
        $product   = new Product(array(
            'code'             =>$data['code'],
            'cat'              =>$catid,
            'access'           =>$data['access'],
            'priority'         =>$data['priority'],

            'title'            =>$data['title'],
            'description'      =>$data['description'],
            'extraDescription' =>$data['extraDescription'],

            'price'            =>$data['price'],
            'count'            =>$data['count'],
            'stat'             =>$data['stat'],
            'visibility'       =>$data['visibility'],
            'label'            =>$data['label'],

            'mainImages'       =>$data['mainImages']['address'],
            'images'           =>$data['images'],
            
            'typeFields'       =>$data['dynamicProductFields']
        ));
        
        if(count($data['images']) >= 500)
            return false;
        
        return $product->saveAll();
    }
    
    
   /**
   * EAV::getProductData()
   *    get full product data
   * 
   * @param string $data        fieds of product
   * @param int    $catid       product category id
   * @return array of result 
   */
    public static function getProductData($productId,$options = array())
    {
        $product   = new Product(array(
            'id'             =>$productId,
        ));
        if($options['baseUrlPath'])
            $product->baseUrlPath = $options['baseUrlPath']; // Upload folder Base Url
        return $product->getAll();
    }
    
    
    /**
   * EAV::editProduct()
   *    edits product 
   * 
   * @param string $data        fieds of product
   * @param int    $catid       product category id
   * @return array of result 
   */
    public static function editProduct($id,$data,$catid)
    {
        $product   = new Product(array(
            'id'               =>intval($id),
            'code'             =>$data['code'],
            'cat'              =>$catid,
            'access'           =>$data['access'],
            'priority'         =>$data['priority'],

            'title'            =>$data['title'],
            'description'      =>$data['description'],
            'extraDescription' =>$data['extraDescription'],

            'price'            =>$data['price'],
            'count'            =>$data['count'],
            'stat'             =>$data['stat'],
            'visibility'       =>$data['visibility'],
            'label'            =>$data['label'],

            'mainImages'       =>$data['mainImages']['address'],
            'images'           =>$data['images'],
            
            'typeFields'       =>$data['dynamicProductFields']
        ));
        
        if(count($data['images']) >= 500)
            return false;
            
        return $product->UpdateAll();
    }
    
    
    
     /**
   * EAV::deleteProduct()
   *    delete product 
   * 
   * @param int $id       id of the product that should be deleted
   * @return array of result 
   */
    public static function deleteProduct($id)
    {
        $product   = new Product(array(
            'id'               =>intval($id)
        ));
        return $product->delete();
    }
    
    
    
    
    
    
    
    
    
    
    

    
    
   /**
   * EAV::search()
   *    serach in EAV model
   *    search in custom field of each product 
   *    the search and its comparison is `AND` type
   * 
   * @param  array $array array contains field id as `key` and field value 
   *   as `value` of itself
   * @param  int   $start start of products pointer(used in pagination)
   * @param  int   $limit count of products in each query 
   * @return array of products
   */
    public static function search($array = false,$start = 0,$limit=0)
    {
        // Search Query Builder
        if(is_array($array))
        {
            foreach($array as $field_id=>$field_value)
                $search_fields[] = ' `'.self::$product_tabble.'`.`id`  IN(SELECT `product_id` FROM `'.self::$product_value.'` WHERE `field_id`='.$field_id.' AND `value`="'.$field_value.'")';
            $query_text =   implode(' AND ',$search_fields);    
        }else
            $query_text = ' 1 ';
            
        if(!$limit) $limit = self::$default_query_count;
        
        $rs         =   self::$DB->query('SELECT `'.self::$product_tabble.'`.* FROM `'.self::$product_tabble.'` WHERE '.$query_text.' LIMIT '.$start.','.$limit);
        $res        =   self::$DB->loadInArray($rs);
        
        return $res;
    }
    
   
    
}


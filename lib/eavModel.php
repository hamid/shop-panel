<?php

class EAV{
    
    public  static $DB;
    
    public  static $default_query_count     = 10;
    
    
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


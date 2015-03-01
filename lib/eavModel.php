<?php

class eav{
    
    public  static $DB;
    public  static $product_tabble          =   'product';
    public  static $product_value           =   'product_type_field_value';
    
    public  static $default_query_count     = 10;
    
    
   /**
   * Core::setDriver()
   *    set database driver
   *    this driver should have query,fetch,loadInArray methods
   * 
   * @param object $DB object of database driver
   */
    public static function  setDriver($DB) {
        self::$DB = $DB;
    }

    
   /**
   * Core::search()
   *    serach in EAV model
   *    search in custom field of each product 
   *    the search and its comparison is `AND` type
   * 
   * @param  array $array array contains field number as `key` and field value 
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


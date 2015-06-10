<?php
/**
 * Category
 * 
 * contain  methods for fetch, Create, Update and Delete Category on Database
 * 
 * @package shopPanel
 * @author Hamid Reza Salimian (github.com/hamid)
 * @copyright 2015
 * @version 1.0
 * @license GNU General Public License version 2 or later;
 */


class Category
{
    
    public     $id;
    public     $parent_id;
    public     $title;
    public     $type_id;
    public     $access;
    
    
    protected static $driver;
    protected static $table         =   'product_cat';
    protected static $prucuctTable  =   'product';
    
    
    


    public function __construct($initData = array()) {
        foreach ($initData as $field=>$val)
            $this->$field = $val;
    }
    
    
  /**
   * Category::setOption()
   *    set initial option for class
   * 
   * @param array $array array of options items
   *        options items lists in static properties of class
  */
    public static function setOption($array){
        foreach ($array as $key=>$val)
                self::$$key  = $val;
    }

    


  /**
   * Category->getChildren()
   *    get children(categories) of this category,infact get sub categories
   * 
   * @param array|string $fields array of fields,
   *        it could be null means all field
   * @return array of category class
  */
    public function getChildren($fields = '*')
    {
        $list = array();
        
        if(is_array($fields))
           $fields = '`'.implode ('`,`', $fields).'`';
         
        $result    = self::$driver->query(" SELECT      $fields "
                                        . " FROM        ".self::$table
                                        . " WHERE       `parent_id`= '".intval($this->id)."'"
                                        . " ORDER BY    `priority`; ");
        while($row  = self::$driver->fetch($result))
            $list[] = new Category($row);
        
        return $this->children = $list;
    }
    
  /**
   * Category->getProducts()
   *    get Products of this category
   * 
   * @param array|string $fields array of fields,
   *        it could be null means all field
   * @return array of product class
  */
    public function getProducts($fields = '*')
    {
        $list = array();
        
        if(is_array($fields))
           $fields = '`'.implode ('`,`', $fields).'`';
         
        $result    = self::$driver->query(" SELECT      $fields "
                                        . " FROM        ".self::$prucuctTable
                                        . " WHERE       `cat`= '".intval($this->id)."'"
                                        . " ORDER BY    `priority`; ");
        while($row  = self::$driver->fetch($result))
            $list[] = new Product($row);
        
        return $this->product = $list;
    }
    
    
    
  /**
   * Category->update()
   *    update fields of category
   * 
   * @param array $fields array of fields that should be update
   *                     
   * @return boolean stat of update
  */
    public function update($fields)
    {
        $fields = implode(' , ', array_map(function ($v, $k) { return "`$k`='$v'"; }, $fields, array_keys($fields)));
        return    self::$driver->query(" UPDATE ".self::$table."
                                         SET    $fields 
                                         WHERE  `id`      =  '".  $this->id   ."';"
                                       );
    }
    
    
    /**
   * Category->save()
   *    save current category into Database
   *                     
   * @return int|boolean number of last inserted id or false
  */
    public function save()
    {
        $stat =    self::$driver->query("INSERT INTO `product_cat`( `priority`, `access`, `parent_id`, `title`, `type_id`) "
                                     . "VALUES ('0','".$this->access."','".$this->parent_id."','".$this->title."','".$this->type_id."')");
        
        if($stat)
            return $this->id = self::$driver->getLastId();
        return false;
    }
    
    
    
    
    
    
}


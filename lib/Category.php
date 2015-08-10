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


class Category extends Base
{
    
    public     $id;
    public     $parent_id;
    public     $title;
    public     $type_id;
    public     $access;
    
    
    protected static $table         =   'product_cat';
    protected static $productTable  =   'product';
    
    
    


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
   * Category->get()
   *    get data(fields) of the category
   * 
   * @return array of category fields
  */
    public function get()
    {
        $list = array();
        if(empty($this->id))
            return false;
         
        $result    = self::$driver->query(" SELECT      * "
                                        . " FROM        ".self::$table
                                        . " WHERE       ".self::$appCondition
                                                . "`id`= '".intval($this->id)."'");
        if($row  = self::$driver->fetch($result))
            foreach ($row as $key=>$item)
                $this->$key = $item;
        return $row;
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
                                        . " WHERE       ".self::$appCondition
                                                . "`parent_id`= '".intval($this->id)."'"
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
                                        . " FROM        ".self::$productTable
                                        . " WHERE       ".self::$appCondition
                                                . "`cat`= '".intval($this->id)."'"
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
                                         WHERE  ".self::$appCondition."   `id`      =  '".  $this->id   ."';"
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
        $priority  = "(SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='".self::$table."')";
        $stat      =    self::$driver->query("INSERT INTO ".self::$table."( "
                                                                            . self::$appExtraField
                                                                            . " `priority`,"
                                                                            . " `access`,"
                                                                            . " `parent_id`,"
                                                                            . " `title`,"
                                                                            . " `type_id`) "
                                                                ." VALUES ( "
                                                                            . self::$appExtraFieldValue
                                                                            . " ".$priority.","
                                                                            . "'".$this->access."',"
                                                                            . "'".intval($this->parent_id)."',"
                                                                            . "'".$this->title."',"
                                                                            . "'".intval($this->type_id)."'"
                                                                        . ")");
        
        if($stat)
            return $this->id = self::$driver->getLastId();
        return false;
    }
    
  /**
   * Category->delete()
   *    delete current category from Database
   *                     
   * @return boolean  :state of delete category
  */
    public function delete()
    {
        $stat      =    self::$driver->query("DELETE FROM ".self::$table." WHERE ".self::$appCondition." `id`='".intval($this->id)."' ");
        
        if($stat)
            return true;
        return false;
    }
    
    
    
    
    
    
}


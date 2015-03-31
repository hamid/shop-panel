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
    
    
    protected static $driver;
    protected static $table  =   'product_cat';
    
    
    


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
   *        options items lists in static properties of class
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
    
    
    
}

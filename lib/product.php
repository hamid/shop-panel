<?php
/**
 * Product
 * 
 * contain  methods for fetch, Create, Update and Delete Product on Database
 * 
 * @package shopPanel
 * @author Hamid Reza Salimian (github.com/hamid)
 * @copyright 2015
 * @version 1.0
 * @license GNU General Public License version 2 or later;
 */
class Product
{
    
    public     $id;
    public     $cat;
    public     $priority;
    public     $access;
    public     $price;
    public     $stat;
    public     $label;
    
    
    protected static $driver;
    protected static $table =   'product';
    
    

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
   * Product->update()
   *    update fields of product
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



    public function fetchData()
    {
        
    }
    
    
    public function getFullDetail()
    {
        
    }
    
    
    public function save()
    {
        
    }
    
    
    
}


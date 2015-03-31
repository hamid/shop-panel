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
    
    

    public function __construct($id,$initData = array()) {
        $this->id   = $id;
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


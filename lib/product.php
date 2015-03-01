<?php

class product
{
    
    public      $id;
    public      $cat;
    private     $priority;
    private     $access;
    private     $price;
    private     $stat;
    private     $label;
    
    
    public function __construct($initData = array()) {
        foreach ($initData as $field=>$val)
            $this->$field = $val;
    }
    
    
    
    public function getFullDetail()
    {
        
    }
    
    
    public function save()
    {
        
    }
    
    
    
}


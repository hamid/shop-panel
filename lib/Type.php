<?php
/**
 * Type
 * 
 * contain  methods for fetch, Create, Update and Delete Type on Database
 * 
 * @package shopPanel
 * @author Hamid Reza Salimian (github.com/hamid)
 * @copyright 2015
 * @version 1.0
 * @license GNU General Public License version 2 or later;
 */


class Type extends Base
{
    
    public      $id;
    public      $title;
    public      $fields;
    public      $fieldset;
    
    
    protected static $table                 =   'product_type';
    protected static $table_fields          =   'product_type_field';
    protected static $table_fieldset        =   'product_type_fieldset';
    protected static $table_fields_value    =   'product_type_field_value';
    protected static $category_table        =   'product_cat';
    protected static $product_table         =   'product';
    
    
    


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
   * Category->getFieldsets()
   *    get all fieldset of type
   * @param boolean   $getField  whether load its fields
   * 
   * @return array of Fieldsets 
  */
    public function getFieldsets($getField = false)
    {
        $this->fieldset = array();
        $result         = self::$driver->query(" SELECT      * "
                                                . " FROM        ".self::$table_fieldset
                                                . " WHERE       ".self::$appCondition."   `type_id`= '".intval($this->id)."'"
                                                . " ORDER BY    `priority` ASC; ");
        while($row      = self::$driver->fetch($result))
        {
            if($getField)
                $row['fields'] = $this->getFields($row['id']);
            $this->fieldset[]  = $row; 
        }
        
        return  $this->fieldset;
    }
    
    
    /**
   * Type->addFieldset()
   *    add fieldset to current type
   *                     
   * @return boolean 
  */
    public function addFieldset($title)
    {
        if(empty($this->id))
            return false;
        
        $stat      =   self::$driver->query("INSERT INTO ".self::$table_fieldset."( "
                                                    . self::$appExtraField
                                                    . "`type_id`,"
                                                    . "`priority`,"
                                                    . "`title`"
                                                    . ")"
                                               . " VALUES ("
                                                    . self::$appExtraFieldValue
                                                    . "'".intval($this->id)."',"
                                                    . "".$this->getLastFieldId('query',  self::$table_fieldset).","
                                                    . "'".$title."' ); ");
        
        if($stat)
            return self::$driver->getLastId();
        return false;
    }
    
    /**
   * Type->editFieldset()
   *    edit fieldset from current type
   * @param int   $fieldset_id  id of fieldset,
   * @param array $properties    array of properties that should be update,
   *        
   *                     
   * @return boolean 
  */
    public function editFieldset($fieldset_id,$properties)
    {
        if(empty($fieldset_id))
            return false;
        
        
        $properties = implode(' , ', array_map(function ($v, $k) { return "`$k`='$v'"; }, $properties, array_keys($properties)));
        return    self::$driver->query(" UPDATE ".self::$table_fieldset."
                                         SET    $properties 
                                         WHERE ".self::$appCondition."  `id`      =  '". intval($fieldset_id)   ."'  AND  `type_id` = '" . intval($this->id) . "'  ;"
                                       );
    }
    
    
    /**
   * Type->deleteFieldset()
   *    delete Fieldset from current Type
   * @param int   $fieldset_id  id of fieldset,
   *                     
   * @return boolean  :state of delete 
  */
    public function deleteFieldset($fieldset_id)
    {
        $stat      =    self::$driver->query("DELETE FROM ".self::$table_fieldset." WHERE ".self::$appCondition." `id`='".intval($fieldset_id)."' AND  `type_id` = '" . intval($this->id) . "'  ");
        if($stat)
            return true;
        return false;
    }
    
    
    
    

  
  /**
   * Category->getFields()
   *    get all fields of type
   * 
   * @return array of Fields 
  */
    public function getFields($fieldset = false)
    {
        if($fieldset)
            $fieldsetCondition = ' AND `fieldset_id` = "'.intval($fieldset).'" ';
        else
            $fieldsetCondition = '';
        
        $list      = array();
        $result    = self::$driver->query(" SELECT      * "
                                        . " FROM        ".self::$table_fields
                                        . " WHERE       ".self::$appCondition." `type_id`= '".intval($this->id)."' "
                                        .  $fieldsetCondition
                                        . " ORDER BY    `priority` ASC; ");
        while($row      = self::$driver->fetch($result))
        {
            if($row['options'])
                $row['options'] = json_decode($row['options']);
            $list[]     = $row;
        }
       
            return $this->fields = $list;
    }
    
    
  /**
   * Type->addField()
   *    add fields to current type                  
   * @return boolean 
  */
    public function addField($fieldset_id,$title,$structure,$searchable,$option)
    {
        if(empty($this->id))
            return false;
        
        $option    =   json_encode($option,JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
        $option    =   ($option == 'null')?'':$option;
        
        $stat      =   self::$driver->query("INSERT INTO ".self::$table_fields."("
                                                            . self::$appExtraField
                                                            . " `type_id`,"
                                                            . "`fieldset_id`,"
                                                            . "`priority`,"
                                                            . " `title`,"
                                                            . " `structure`,"
                                                            . "`searchable`,"
                                                            . " `options`)"
                                               . " VALUES ("
                                                            . self::$appExtraFieldValue
                                                            . "'".intval($this->id)."',"
                                                            . " '".$fieldset_id."' ,"
                                                            . "".$this->getLastFieldId('query').","
                                                            . "'".$title."',"
                                                            . "'".$structure."',"
                                                            . " '".$searchable."' ,"
                                                            . "'".$option."' ); ");
        
        if($stat)
            return true;
        return false;
    }
  /**
   * Type->editField()
   *    edit field from current type
   * @param int   $field_id  id of field,
   * @param array $properties    array of properties that should be update,
   *        
   *                     
   * @return boolean 
  */
    public function editField($field_id,$properties)
    {
        if(empty($field_id))
            return false;
        
        if($properties['options'])
            $properties['options'] = json_encode($properties['options'],JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
        
        $properties = implode(' , ', array_map(function ($v, $k) { return "`$k`='$v'"; }, $properties, array_keys($properties)));
        return    self::$driver->query(" UPDATE ".self::$table_fields."
                                         SET    $properties 
                                         WHERE   ".self::$appCondition." `id`      =  '". intval($field_id)   ."'  AND  `type_id` = '" . intval($this->id) . "'  ;"
                                       );
    }
    
  /**
   * Type->deleteField()
   *    delete Field from current Type
   * @param int   $field_id  id of field,
   *                     
   * @return boolean  :state of delete 
  */
    public function deleteField($field_id)
    {        
        $stat      =    self::$driver->query("DELETE FROM ".self::$table_fields." WHERE ".self::$appCondition." `id`='".intval($field_id)."' AND  `type_id` = '" . intval($this->id) . "'  ");

        if($stat)
            return true;
        return false;
    }
    
    
  /**
   * Type->getLastFieldId()
   *    get the last id of field table 
   *    its often used as priority       
   *                     
   * @return string 
  */
    public function getLastFieldId($mode = 'int',$table=false)
    {
        if(!$table)
            $table = self::$table_fields;
        
        
        $query  = "(SELECT AUTO_INCREMENT AS `AI` FROM information_schema.TABLES WHERE TABLE_SCHEMA='".self::$driver->database."' AND TABLE_NAME='".$table."')";
        if($mode == 'query')
            return $query;
        
        $rs     = self::$driver->query($query);
        $AI     = self::$driver->fetch($rs);
        return  $AI['AI'];
    }


    
    
  /**
   * Type->update()
   *    update fields of Type
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
                                         WHERE  ".self::$appCondition." `id`      =  '". intval($this->id)   ."';"
                                       );
    }
    
    
  /**
   * Type->save()
   *    save current Type into Database
   *                     
   * @return int|boolean number of last inserted id or false
  */
    public function save()
    {
        $stat      =    self::$driver->query("INSERT INTO ".self::$table."( "
                                                        . self::$appExtraField
                                                        . "`title`"
                                                . ") VALUES ("
                                                        . self::$appExtraFieldValue
                                                        . "'".$this->title."'"
                                                . ")");

        if($stat)
            return $this->id = self::$driver->getLastId();
        return false;
    }
    
  /**
   * Type->delete()
   *    delete current Type from Database
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
    
    
  /**
   * Type->getCategoryCount()
   *    get count of  Categories that set this type
   *                     
   * @return int  :number of categories
  */
    public function getCategoryCount()
    {
        $stat      =    self::$driver->query("SELECT COUNT(*) AS `cnt` FROM ".self::$category_table." WHERE ".self::$appCondition." `type_id`='".intval($this->id)."' ");
        $stat      =    self::$driver->fetch($stat);
        
        if($stat['cnt'])
            return $stat['cnt'];
        return false;
    }
    
    
    
    
    
  
    
    
    
    
    
    
}


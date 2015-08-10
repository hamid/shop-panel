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
class Product extends Base
{
    
    public     $id;
    public     $code;
    public     $cat;
    public     $access;
    public     $priority;
    
    public     $title;
    public     $description;
    public     $extraDescription;
    
    public     $price;
    public     $count;
    public     $stat;
    public     $visibility;
    public     $label;
    
    public     $mainImages;
    public     $images;
    
    public     $typeFields; // array containa fieldset and fields of product type
    
    public     $baseUrlPath = '';
    
    
    protected static $table             =   'product';
    protected static $table_image       =   'product_image';
    protected static $table_description =   'product_description';
    protected static $table_type_fields =   'product_type_field_value';
    protected static $table_type_structure_fields =   'product_type_field';
    
    

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
   * Product->save()
   *    save fields of product
   * 
   *                     
   * @return boolean stat of save
  */
    public function save()
    {
        $priority  = "(SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='".self::$table."')";
        $stat      =    self::$driver->query("INSERT INTO ".self::$table."( "
                                                                            . self::$appExtraField
                                                                            . " `priority`,"
                                                                            . " `access`,"
                                                                            . " `cat`,"
                                                                            . " `title`,"
                                                                            . " `description`, "
                                                                            . " `image`, "
                                                                            . " `price`, "
                                                                            . " `count`, "
                                                                            . " `visibility`, "
                                                                            . " `stat`, "
                                                                            . " `label`) "
                                                                ." VALUES ( "
                                                                            . self::$appExtraFieldValue
                                                                            . " ".$priority.","
                                                                            . "'".$this->access."',"
                                                                            . "'".intval($this->cat)."',"
                                                                            . "'".$this->title."',"
                                                                            . "'".strip_tags($this->description)."',"
                                                                            . "'".$this->mainImages."',"
                                                                            . "'".intval($this->price)."',"
                                                                            . "'".$this->count."',"
                                                                            . "'".$this->visibility."',"
                                                                            . "'".$this->stat."',"
                                                                            . "'".$this->label."'"
                                                                        . ")");
        
        if($stat)
            return $this->id = self::$driver->getLastId();
        return false;
    }
    
    
  /**
   * Category->saveExtraDescription()
   *    save extra description of product
   * 
   * @return boolean stat of save
  */
    public function saveExtraDescription()
    {
        if(empty($this->id))
            return false;
        $stat      =    self::$driver->query("INSERT INTO ".self::$table_description."( "
                                                                            . self::$appExtraField
                                                                            . " `product_id`,"
                                                                            . " `text`) "
                                                                ." VALUES ( "
                                                                            . self::$appExtraFieldValue
                                                                            . " ".$this->id.","
                                                                            . "'".$this->extraDescription."'"
                                                                        . ")");
        if($stat)
            return self::$driver->getLastId();
        return false;
    }
    
    
    /**
   * Category->saveImages()
   *    save images of product
   * 
   * @return boolean stat of save
  */
    public function saveImages()
    {
        if(empty($this->id))
            return false;
        if(is_array($this->images))
            foreach($this->images as $image)
            {
                $stat      =    self::$driver->query("INSERT INTO ".self::$table_image." ( "
                                                                            . self::$appExtraField
                                                                            . " `product_id`,"
                                                                            . " `address`) "
                                                                    ." VALUES ( "
                                                                            . self::$appExtraFieldValue
                                                                            . " ".$this->id.","
                                                                            . "'".$image['address']."'"
                                                                    . ")");
            }
        
        if($stat)
            return self::$driver->getLastId();
        return false;
    }
    
     /**
   * Category->saveTypeField()
   *    save fields of product's type
   *    this method save $typeFields properties
   *    $typeFields shold contain fieldset array like this
   *    => array(
   *        'fields' =>array(
   *            array(
   *                'id'    => 1         [int]
   *                'model' => 'value'   [string]
   *             )
   *        )
   *     )
   * 
   * @return boolean stat of save
  */
    public function saveTypeField()
    {
        if(empty($this->id))
            return false;
        
        if(is_array($this->typeFields))
            foreach($this->typeFields as $fieldset)
            {
                if(is_array($fieldset))
                    foreach($fieldset['fields'] as $field)
                    {
                        $stat      =    self::$driver->query("INSERT INTO ".self::$table_type_fields." ( "
                                                                            . self::$appExtraField
                                                                            . " `product_id`,"
                                                                            . " `field_id`,"
                                                                            . " `value`) "
                                                                    ." VALUES ( "
                                                                            . self::$appExtraFieldValue
                                                                            . " ".$this->id.","
                                                                            . " ".$field['id'].","
                                                                            . "'".$field['model']."'"
                                                                    . ")");
                    }
                    
                
            }
            
        
        if($stat)
            return self::$driver->getLastId();
        return false;
    }
    
    
    
  /**
   * Category->saveAll()
   *    save all fields of product
   * 
   * @return boolean stat of save
  */
    public function saveAll()
    {
        $stat = true;
        
        $stat = $this->save()                   && $stat;
        $stat = $this->saveTypeField()          && $stat;
        $this->saveImages();
        $this->saveExtraDescription();
        
        return  $stat;
    }
    
    
    
    
    
    
    
  /**
   * Category->get()
   *     get  product brief data
   * 
   * @return product
  */
    public function get()
    {
        if(empty($this->id))
            return false;
        
        $result    = self::$driver->query(" SELECT      *  "
                                        . " FROM        ".self::$table
                                        . " WHERE       ".self::$appCondition
                                                . "`id`= '".intval($this->id)."'");
        if($row  = self::$driver->fetch($result))
        {
            foreach ($row as $key=>$val)
                $this->$key = $val;
            $this->mainImages    = $row['image'];
            $this->mainImagesUrl = $this->baseUrlPath . $row['image'];
            
            return $this;
        }else
            return false;
        
    }
    
    /**
   * Category->get()
   *     get  product brief data
   * 
   * @return product
  */
    public function getDescription()
    {
        if(empty($this->id))
            return false;
        
        $result    = self::$driver->query(" SELECT      *  "
                                        . " FROM        ".self::$table_description
                                        . " WHERE       ".self::$appCondition
                                                . "`product_id`= '".intval($this->id)."'");
        if($row  = self::$driver->fetch($result))
        {
            $this->extraDescription = htmlspecialchars_decode($row['text']);
            
            return $this;
        }else
            return false;
        
    }
    
    
  /**
   * Category->getTypeField()
   *     get  all fielset and fields of product
   * 
   * @return product
  */
    public function getTypeField()
    {
        if(empty($this->id))
            return false;
        
        $type_id = $this->getProductTypeid();
        if(empty($type_id))
            return false;
        
        $productType   = new Type(array(
            'id'=>$type_id
        ));
        $fielsets = $productType->getFieldsets();
        
        if(self::$appCondition)
            $appCondition = self::$table_type_fields.'.'.self::$appCondition;
        else
            $appCondition = '';
        
        $productFieldSet = array();
        $c = 0;
        
        if(is_array($fielsets))
            foreach ($fielsets as $fielset)
            {
                $productFieldSet[$c] = array(
                    'title' =>$fielset['title'],
                    'id'    =>$fielset['id'],
                    'fields' => array()
                );
                $result    = self::$driver->query(" SELECT      "
                                                            . " `".self::$table_type_fields."`.* ,"
                                                            . " `".self::$table_type_structure_fields."`.`title`,  "
                                                            . " `".self::$table_type_structure_fields."`.`structure`,  "
                                                            . " `".self::$table_type_structure_fields."`.`id` AS `field_id` "
                                                    . " FROM        ".self::$table_type_fields." LEFT JOIN ".self::$table_type_structure_fields.
                                                            " ON  `".self::$table_type_structure_fields."`.`id` = `".self::$table_type_fields."`.`field_id`  "
                                                    . " WHERE       ".$appCondition
                                                            . " `".self::$table_type_structure_fields."`.`fieldset_id` = '".intval($fielset['id'])."'");
                while($row  = self::$driver->fetch($result))
                    $productFieldSet[$c]['fields'][] = $row;
                
                $c++;
            }
        
        $this->typeFields = $productFieldSet;
       
            return $this;
        return false;
    }
    
   /**
   * Category->getTypeField()
   *     get  type id of this product
   * 
   * @return int type id
  */
    public function getProductTypeid()
    {
        $productCategory = new Category(array(
            'id'=>$this->cat
        ));
        $productCategory->get();
        return $productCategory->type_id;
          
    }


    
    
    /**
   * Category->getImages()
   *     get  product images
   * 
   * @return product
  */
    public function getImages()
    {
        if(empty($this->id))
            return false;
        
        $result    = self::$driver->query(" SELECT      *  "
                                        . " FROM        ".self::$table_image
                                        . " WHERE       ".self::$appCondition
                                                . "`product_id`= '".intval($this->id)."'");
        while($row  = self::$driver->fetch($result))
            $this->images[] = array(
                'id'        => $row['id'],
                'name'      => '',
                'url'       => $this->baseUrlPath .$row['address'],
                'address'   => $row['address']
            );
        
        if(is_array($this->images))
            return $this;
        return false;
    }
    
    
    
    
    
  /**
   * Category->getAll()
   *     get full product data
   * 
   * @return product
  */
    public function getAll()
    {
        $this->get();
        $this->getDescription();
        $this->getImages();
        $this->getTypeField();
        
        return $this;
    }
    
    
  /**
   * Product->update()
   *    update fields of product
   * 
   * @param array $fields array of fields that should be update
   *                     
   * @return boolean stat of update
  */
    public function update($fields = false)
    {
        if(empty($this->id))
            return false;
        
        if(!$fields)
            $fields = array(
                'code'             =>$this->code,
                'access'           =>$this->access,
                'priority'         =>$this->priority,

                'title'            =>$this->title,
                'description'      =>$this->description,
                
                'image'            =>$this->mainImages,

                'price'            =>$this->price,
                'count'            =>$this->count,
                'visibility'       =>$this->visibility,
                'stat'             =>$this->stat,
                'label'            =>$this->label

            );
        $fields = implode(' , ', array_map(function ($v, $k) { return "`$k`='$v'"; }, $fields, array_keys($fields)));
        return    self::$driver->query(" UPDATE ".self::$table."
                                         SET    $fields 
                                         WHERE  ".self::$appCondition."  `id`      =  '".  $this->id   ."';"
                                       );
    }
    
    
  /**
   * Product->updateDescription()
   *    update description of product
   * 
   * @param string $text  new description text
   *                     
   * @return boolean stat of update
  */
    public function updateDescription($text = false)
    {
        if(empty($this->id))
            return false;
        
        if($text)
            $this->extraDescription = $text ;
        
        return    self::$driver->query(" UPDATE ".self::$table_description."
                                         SET    `text` = '".$this->extraDescription."' 
                                         WHERE  ".self::$appCondition."  `product_id`  =  '".  $this->id   ."';"
                                       );
    }
    
    
  /**
   * Product->updateImages()
   *    update Images  of product
   * 
   * @param array $images  new images list
   *                     
   * @return boolean stat of update
  */
    public function updateImages($images=FALSE)
    {
        if(empty($this->id))
            return false;
        
        if($images)
            $this->images = $images;
        
        $stat =  $this->deleteImages();
        return   $this->saveImages() && $stat;
        
    }
    
    
  /**
   * Product->updateTypeField()
   *    update type fields of product
   *    each fields should have 
   *            `model`     as value of fields
   *            `value_id`  as id of fields
   * 
   * @param array $fiedset  new images list
   *                     
   * @return boolean stat of update
  */
    public function updateTypeField($fiedset=FALSE)
    {
        if(empty($this->id))
            return false;
        
        if($fiedset)
            $this->typeFields = $fiedset;
        
        if(is_array($this->typeFields))
            foreach($this->typeFields as $fieldset)
            {
                if(is_array($fieldset))
                    foreach($fieldset['fields'] as $field)
                    {
                        $stat      =    self::$driver->query("UPDATE ".self::$table_type_fields."
                                            SET    `value` = '".$field['model']."' 
                                            WHERE  ".self::$appCondition."  `id`  =  '".  $field['value_id']   ."';");
                    }
                    
                
            }
    }
    
    /**
   * Category->updateAll()
   *     update  full product data
   * 
   * @return product
  */
    public function updateAll()
    {
        $this->update();
        $this->updateDescription();
        $this->updateImages();
        $this->updateTypeField();
        
        return $this;
    }
    
    
    
    
    /**
   * Product->deleteImages()
   *    delete all Images  of product
   * 
   *                     
   * @return boolean stat of delete
  */
    public function deleteImages()
    {
        if(empty($this->id))
            return false;
        
            
                return    self::$driver->query("DELETE FROM  ".self::$table_image."
                                         WHERE  ".self::$appCondition."  `product_id`  =  '". intval($this->id)   ."';");
        
    }
    
    /**
   * Product->delete()
   *    delete product
   * 
   *                     
   * @return boolean stat of delete
  */
    public function delete()
    {
        if(empty($this->id))
            return false;
        
            
                return    self::$driver->query("DELETE FROM  ".self::$table."
                                         WHERE  ".self::$appCondition."  `id`  =  '". intval($this->id)   ."';");
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}


<?php

/**
 * DB
 * 
 * @package CMS
 * @author Hamid Reza Salimian (xsx.hamid@gmail.com)
 * @copyright 2012
 * @version 1.0
 * @license GNU General Public License version 2 or later;
 */
class DB{
    
    protected   $uname     = "root";
    protected   $pass      = "";  
    public      $database  = "";  
    public      $mysqli;  
    public      $lastQuery;
    

    
    /**
     * DB::connect()
     * Connect to mySql. Set UTF8 . Select Default Database
     */
    function connect($uname = false,$pass = false, $Database = DATABASE_NAME)
    {
        if(!$uname) 
        {
            $uname = $this->uname;
            $pass  = $this->pass;     
        }
        
        
        $this->database = $Database;
        $this->mysqli   = new mysqli("localhost", $uname, $pass, $Database);
        $this->mysqli->set_charset("utf8");
        
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }
    
    /**
     * DB::close()
     * 
     * @param string $res 
     */
    function close($res="")
    {
        if(is_resource($res))
        {
            mysqli_close($res);
        }
        else
        {
            mysqli_close($this->mysqli);
        }
    }
    
    /**
     * DB::query()
     * 
     * @param mixed $Text  as query must be execute
     * @return database resource  ready for fetch
     */
    function query($Text)
    {
        $this->lastQuery =  $Text;
        return  mysqli_query($this->mysqli,$Text); 
    }
    
    /**
     * DB::fetch()
     * Fetch a result row as an associative array
     * 
     * @param mixed $result
     * @return array contain 
     */
    function fetch($result)
    {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    
    /**
     * DB::setDatabase()
     * Select database 
     * 
     * @param mixed $dbname name of database
     */
    function setDatabase($dbname)
    {
        //mysqli_select_db($this->mysqli,$dbname);
    }
    
    /**
     * DB::testConnection()
     * Test connection to server
     * @return boolean true if mysql_ping is success
     */
    function testConnection()
    {
        if(is_resource($this->mysqli)) {
            return mysqli_ping($this->mysqli);
        }
        return false;
    }
    /**
     * DB::getAffectedRows()
     *
     * @return int The number of affected rows in the last Query
     */
    function getAffectedRows()
    {
        return mysqli_affected_rows($this->mysqli);
    }
    
    /**
     * DB::getNumRows()
     * 
     * @return int The number of rows in last Query.
     */
    function getNumRows( $res )
    {
        return mysqli_num_rows( $res ? $res : $this->mysqli );
    }
    
    
    /**
    * DB::loadInArray() 
    * Load a assoc list of database rows
    *
    * @return array contain Key(fields) and value
    */
    function loadInArray( $result )
    {
      $array = array();
      while($row = $this->fetch($result))
      {  
          $array[] = $row; 
      }  
      return ($array)?$array:false;
    }
   /**
    * DB::escape() 
    * Escapes special characters in a string for use in an SQL statement
    *
    * @return string  the escaped string, or FALSE on error. 
    */
    function escape( $text )
    {
      return mysqli_real_escape_string($this->mysqli,$text);
    }
    
   /**
    * DB::getLastId() 
    * Get the ID generated in the last query
    * 
    * @return int|boolean :The ID generated for an `AUTO_INCREMENT` column by the previous query on success,
    *  0 if the previous query does not generate an `AUTO_INCREMENT` value,
    *  or `FALSE` if no MySQL connection was established.
    */
    function getLastId()
    {
        return mysqli_insert_id($this->mysqli);
    }
    
    
}


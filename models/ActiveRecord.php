<?php
namespace Model;

class ActiveRecord {

    // Database
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];
    public $id;

    // Alerts and messages
    protected static $alerts = [];
    
    // Define the connection to the database
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlert($type, $message) {
        static::$alerts[$type][] = $message;
    }

    // Validation
    public static function getAlerts() {
        return static::$alerts;
    }

    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // SQL query to create an object in memory
    public static function querySQL($query) {
        // Query the database.
        $result = self::$db->query($query);

        // Iterate the results 
        $array = [];
        while($registro = $result->fetch_assoc()) {
            $array[] = static::createObject($registro);
        }

        // Free up memory
        $result->free();

        // Return the results
        return $array;
    }

    // Create an object in memory equal to the database
    protected static function createObject($registro) {
        $object = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    // Identify and join the attributes of the database
    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitize data before saving to DB
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach($attributes as $key => $value ) {
            $sanitized[$key] = is_null($value) ? '' : self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Synchronize DB with Objects in memory
    public function synchronize($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Records - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // Update
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->create();
        }
        return $result;
    }

    // All records
    public static function all() {
        $query = "SELECT * FROM " . static::$table;
        $result = self::querySQL($query);
        return $result;
    }

    // Search for a record by its ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = " . $id;
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Search for a record by column and value
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table  ." WHERE $column = '" . $value . "'";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Flat SQL query (use when the model methods are not sufficient)
    public static function SQL($query) {
        $result = self::querySQL($query);
        return $result;
    }

    // Get records with a limit
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$table . " LIMIT " . $limite;
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // Create a new record
    public function create() {
        // Sanitize data
        $attributes = $this->sanitizeAttributes();

        // Insert into the database
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // query results
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    // Update record
    public function update() {
        // sanitize data
        $attributes = $this->sanitizeAttributes();

        // Iterate to add each field from the database
        $valores = [];
        foreach($attributes as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // query SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Update BD
        $result = self::$db->query($query);
        return $result;
    }

    // Delete a record by its id
    public function delete() {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}
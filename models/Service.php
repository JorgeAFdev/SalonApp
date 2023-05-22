<?php
namespace Model;
class Service extends ActiveRecord {
    protected static $table = 'services';
    protected static $columnsDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? null;
        $this->price = $args['price'] ?? null;
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Service Name is required';
        }
        if(!$this->price) {
            self::$alerts['error'][] = 'Service Price is required';
        }
        if((!is_numeric($this->price))) {
            self::$alerts['error'][] = 'Service Price is not valid';
        }
        return self::$alerts;
    }
}
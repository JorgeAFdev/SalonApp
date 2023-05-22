<?php 
namespace Model;

class AdminAppointment extends ActiveRecord {
    protected static $table = 'appointments_services';
    protected static $columnsDB = ['id', 'time', 'client', 'email', 'phone_number', 'service', 'price'];

    public $id;
    public $time;
    public $client;
    public $email;
    public $phone_number;
    public $service;
    public $price;

    public function __construct() {
        $this->id = $args['id'] ?? null;
        $this->time = $args['time'] ?? '';
        $this->client = $args['client'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}
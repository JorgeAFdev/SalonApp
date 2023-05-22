<?php 
namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'last_name', 'email', 'password', 'phone_number', 'admin', 'confirmed', 'token'];

    public $id;
    public $name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmed = $args['confirmed'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Validation messages for account creation
    public function validateNewAccount() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Your Name is required.';
        }
        if(!$this->last_name) {
            self::$alerts['error'][] = 'Your Last Name is required.';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'Your Email is required.';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'El Email no es valido';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'Your Password is required.';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'Your Password must contain at least 6 characters.';
        }
        return self::$alerts;
    }

    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'Your Email is required.';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'Your password is required.';
        }
        return self::$alerts;
    }

    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'Your Email is required.';
        }
        return self::$alerts;
    }
    public function validatePassword() {
        if(!$this->password) {
            self::$alerts['error'][] = 'Your Passwords is required.';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'Your Password must contain at least 6 characters.';
        }
        return self::$alerts;
    }

    public function userExists() {
        $query = " SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";

        $result = self::$db->query($query);

        if($result->num_rows) {
            self::$alerts['error'][] = 'This Email is already registered.';
        }
        return $result;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function checkPasswordAndVerify($email) {
        $result = password_verify($email, $this->password);
        
        if(!$result || !$this->confirmed) {
            self::$alerts['error'][] = 'Invalid password or account not confirmed';
        } else {
            return true;
        }
    }
}
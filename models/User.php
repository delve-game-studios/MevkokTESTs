<?php
/**
 * Model User
 * 
 */
class User extends Database {
    public function __construct() {
        $this->object_of = "User";
        $this->table = "users";
        parent::__construct();
    }

    public function __destruct() {}

    /**
     * Gives access to the model's database functionality
     * @return User
     */
    public static function db() {
        $instance = new User();
        return $instance;
    }
}
?>
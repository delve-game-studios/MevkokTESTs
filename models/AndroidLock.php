<?php
/**
 * Model AndroidLock
 * 
 */
class AndroidLock extends Database {
    public function __construct() {
        $this->object_of = "AndroidLock";
        $this->table = "android_locks";
        parent::__construct();
    }

    public function __destruct() {}

    /**
     * Gives access to the model's database functionality
     * @return AndroidLock
     */
    public static function db() {
        $instance = new AndroidLock();
        return $instance;
    }
}
?>
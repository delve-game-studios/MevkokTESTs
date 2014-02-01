<?php
/**
 * Model Page
 * 
 */
class Page extends Database {
    public function __construct() {
        $this->object_of = "Page";
        $this->table = "pages";
        parent::__construct();
    }

    public function __destruct() {}

    /**
     * Gives access to the model's database functionality
     * @return Page
     */
    public static function db() {
        $instance = new Page();
        return $instance;
    }
}
?>
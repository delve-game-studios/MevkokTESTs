<?php
/*
 * Controller AndroidLock
 */
class AndroidLock extends Application {
    public function __construct() {
        parent::__construct();
    }
    public function getXMLContent($file){        
        $info = (isset($file)) ? $file : '';
        $steam_data = file_get_contents($info);
        $xml = new SimpleXMLElement($steam_data);
        return $xml;
    }
    public function index() {
        $this->renderPartial("android_lock/".$_REQUEST['page'].".php");
    }
}
?>
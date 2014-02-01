<?php
/**
 * Autoloads model classes when they are needed
 * @param string $name Model class name
 */
function __autoload($name) {
    $filePath = './models/' . $name . '.php';
    if(file_exists($filePath)) {
        include_once $filePath;
    }
}
?>

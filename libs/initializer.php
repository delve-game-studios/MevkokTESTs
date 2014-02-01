<?php
/**
 * <p>Module loader class.</p>
 * <p>Usualy is included in the dispatcher file.</p>
 */
class Azaret {
    
    /**
     * Initializes the the framework and common libraries 
     */
    static function init() {
        // Define Global Constants
        define('LibraryFolder', dirname(__FILE__));
        define('DocumentRoot', dirname(LibraryFolder));
        define('AppPath', str_ireplace($_SERVER['DOCUMENT_ROOT'], '', DocumentRoot));
        // Load Global Modules And Libraries
        self::load(array(// Loading application modules
            DocumentRoot . '/libs/common', // Framework libraries
            DocumentRoot . '/libs/framework', // Framework libraries
            DocumentRoot . '/helpers',
            DocumentRoot . '/config', // Configuration files

            DocumentRoot . '/controllers/Application.php' // Load the main cotroller
        ));
        
        if(ENV == 'production') {
            error_reporting(0);
        } else {
            error_reporting(E_ALL);
        }
    }

    /**
     * <p>Includes an array of folders and/or files to your project.</p>
     * @param array $modules Array of modules
     * @example
     * <p>Azaret::load(array('./lib/framework','./lib/xml'));</p>
     */
    static function load($modules){
        if(is_array($modules)){
            foreach($modules as $module){
                self::import($module);
            }
        }else{
            self::import($modules);
        }

    }

    /**
     * <p>Includes all files from a given folder or a single file.</p>
     * @param string $path The path to the module or file
     * @example
     * Azaret::import('lib/xml'); - it will include all the php files from the lib/xml folder
     */
    static function import($path) {
        if (is_dir($path)) {
            $dir = opendir($path);
            while ($file = readdir($dir)) {
                if (preg_match('/.*?\.php$/i', $file)) {
                    require_once $path . '/' . $file;
                }
            }
        } else {
            require_once $path;
        }
    }
    
    /**
     * Includes a library from the libs folder. The library folder should contan a main.php file that will be included.
     * @param string $name The name of the librarie's folder.
     */
    static function useLib($name) {
        self::import(DocumentRoot . '/libs/' . $name .'/main.php');
    }
}
?>

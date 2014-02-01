<?php
/**
 * Filename: index.php.
 * This file is the application dispatcher.
 * Here are loaded the intial modules needed for the application to run and executes tha routes given to the application
 */

require dirname(__FILE__) . '/libs/initializer.php';

Azaret::init();

// Import your libraries and modules here.

Route::executeRoute();// routes juggler.
?>

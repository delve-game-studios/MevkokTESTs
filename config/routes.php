<?php
Route::$route=array(
    '/'=>array('controller'=>'Pages','action'=>'index'),
    '/site'=>array('controller'=>'Pages','action'=>'index'),
    '/android/:page'=>array('controller'=>'AndroidLock','action'=>'index'),
    '/steam'=>array('controller'=>'Application','action'=>'steam_xml'),
    '/steam/users/'=>array('controller'=>'Application','action'=>'steam_xml','users'=>'1'),
    '/steam/user/'=>array('controller'=>'Application','action'=>'steam_xml'),
    '/steam/user/:user'=>array('controller'=>'Application','action'=>'steam_xml'),
    '/p/:pid'=>array('controller'=>'Pages','action'=>'page'),
    '/logout'=>array('controller'=>'Site','action'=>'logout'),
    '/login'=>array('controller'=>'Site','action'=>'login_page'),
    '/auth'=>array('controller'=>'Site','action'=>'login'),
    '/addCategory'=>array('controller'=>'Application','action'=>'createCategory'),
    '/delCategory/:pid'=>array('controller'=>'Application','action'=>'removeCategory'),
    '/:page'=>array('controller'=>'Pages','action'=>'index'),
    //TODO: your routes here
    '/:controller/:action'=>null, //default settings
    '/:controller/:action/:id'=>null //default settings
);
?>

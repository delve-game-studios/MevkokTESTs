<?php
if(!isset($_SESSION['faction'], $_SESSION['user']) && $_SESSION['faction'] != 'ShadowBuilders'){
    redirectTo('/login');
}
?>
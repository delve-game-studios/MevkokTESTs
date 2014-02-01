<?php
header('Content-type: text/xml');
$array = $this->steam();
if(isset($_REQUEST['user'])){
    echo $array['player'];
}else{
    echo '<players>';
    foreach($array as $ply){
        echo '<player>'.$ply['player'].'</player>';
    }
    echo '</players>';
}
?>
<?php
$this->steam();
echo '<pre>';
if(isset($_REQUEST['user'])){
    var_dump($this->player);
}else{
    var_dump($this->players);
}
?>
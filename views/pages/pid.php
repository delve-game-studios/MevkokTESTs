<?php
if(isset($this->error) && !empty($this->error)){
    echo $this->error;
}else{
    if($this->page){
        if(file_exists('./views/pages/p/'.$this->page[0]->path.'/index.php')){
            $this->renderPartial('/pages/p/'.$this->page[0]->path.'/index.php');
        }else{
            $this->renderPartial('/pages/SlideMenu/index.php');
            die('<center><h1>This page doesn\'t exist!</h1></center>');
        }
    }else{
        $this->renderPartial('/pages/SlideMenu/index.php');
        die('<center><h1>This page doesn\'t exist!</h1></center>');
    }
}
?>
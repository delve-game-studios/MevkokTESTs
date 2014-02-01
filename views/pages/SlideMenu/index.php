<link rel="stylesheet" href="<?= routeTo('/public/SlideMenu/css/style.css') ?>">
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="<?= routeTo('/public/SlideMenu/js/jquery.scrollview.js') ?>"></script>

<div>
<div id="SideMenu">
    <?php
    if($_SESSION['rank'] == 9){
    ?>
    <div id="addNewCategory" class="unselectable greenBackground">Add Category</div>
    <?php
    }
    foreach($this->pages as $output){ ?>
    <div class="unselectable"><a class="unselectable" href="<?= routeTo("/p/".$output->id) ?>"><?= $output->name ?></a><?php if($_SESSION['rank'] == 9){ ?><a id="X" href="<?= routeTo("/delCategory/".$output->id.'|'.$output->path) ?>"></a><?php } ?></div>
    <?php } ?>
</div>
<div class="unselectable" id="SideMenu-Toggle">Show Categories</div> <?php //&#10097; - Right Arrow ?>
</div>
<div id="newCategoryDiv">
        <span style="float: right;" id="newCategoryForm-Exit" href="javascript:void(0);">X</span><br>
    <form action="<?= routeTo('/addCategory') ?>" method="POST" id="newCategoryForm" >
        <input id="category-name" type="text" name="category-name" placeholder="Name"><br>
        <input id="category-path" type="text" name="categoty-path" placeholder="Path"><br>
        <input type="submit" value="Create!">
    </form>
</div>
<script src="<?= routeTo('/public/SlideMenu/js/SlideMenu.js') ?>"></script>
<script>
    $("#SideMenu").scrollview();
</script>
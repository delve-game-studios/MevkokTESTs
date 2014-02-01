( function( $ ) {
    var $menu = $('#SideMenu');
    var $button = $('#SideMenu-Toggle');
    var $new = $('#addNewCategory');
    var $path = $('#category-path');
    $button.on('click', function(){
        if($menu.css('left') === '-225px'){
            $menu.animate({
                left: '0'
            }, 1000);
            $button.animate({
                left: '10%'
            }, 1000);
            $button.html("Hide Categories"); //&#10096; - Left Arrow
        }else{
            $menu.animate({
                left: '-225px'
            }, 1000);
            $button.animate({
                left: '-4.7%'
            }, 1000);
            $button.html("Show Categories"); //&#10097; - Right Arrow
        }
    });
    $new.on('click', function(){
        var $form = $('#newCategoryDiv');
        if($form.css('top') === '-9999px'){
            $form.animate({
               top: '40%' 
            }, 1000);
        }else{
            $form.animate({
                top: '-9999px'
            }, 1000);
        }
        
    });
    $('#newCategoryForm-Exit').on('click', function(){
        var $form = $('#newCategoryDiv');
        $form.animate({
            top: '-9999px'
        }, 1000);
    });
    $path.blur(function(){
        var $path_text = this.value;
        var $path_arr = $path_text.split(' ');
        var $new_path = $path_arr.join('');
        this.value = $new_path;
    });
})(jQuery);

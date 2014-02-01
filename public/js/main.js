$(document).ready(function(){
    $(function(){
        $('a').on('click', function(){
            var link = this.getAttribute('data-url');
            $.ajax(link, {
                method: 'GET',
                success: function(data){
                    $('#body').empty().append(data);
                }
            });
        });
    });
    $(function(){
        $('a.page-number').on('click', function(){
            var link = this.href;
            $.ajax(link, {
                method: 'GET',
                complete: function(data){
                    $('#body').empty().append(data.responseText);
                }
            });
            return false;
        });
        $('a.page-navigation').on('click', function(){
            var link = this.href;
            $.ajax(link, {
                method: 'GET',
                complete: function(data){
                    $('#body').empty().append(data.responseText);
                }
            });
            return false;
        });
    });
    $(function(){
        $('body').attr('id','site-top-corner');
    });
});
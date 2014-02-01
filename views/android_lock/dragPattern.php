<html>
    <head>
        <script src="<?= routeTo("/public/js/jquery-1.10.2.js") ?>"></script>
        <script src="<?= routeTo("/public/js/jquery-ui-1.10.3.min.js") ?>"></script>
        <script src="<?= routeTo("/public/javascript/kineticJS.js") ?>"></script>
        <link rel="stylesheet" href="<?= routeTo("/public/android/style.css") ?>">
    </head>
    <body>
        <div id="dragPad"></div>
        <input type="hidden" id="code">
        <script type="text/javascript">
            $(document).ready(function(){
                var $dragPad = document.getElementById('dragPad').getBoundingClientRect();
                var $pass = [];
                var $dragPadcenter = (parseInt($('#dragPad').css('border-radius'))/parseInt(2));
                $.ajax({
                    url: "<?= routeTo("/public/android/dragPattern.xml") ?>",
                    method: 'GET',
                    success: function(DATA){
                        var dragItems = DATA.getElementsByTagName('dragItems')[0].getElementsByTagName('item');
                        for(var i = 0;i<9;i++){
                            var value = dragItems[i].getAttribute('value');
                            var active = parseInt(dragItems[i].getAttribute('active'));
                            var x = parseInt(dragItems[i].getAttribute('x')) + parseInt($dragPad.left);
                            var y = parseInt(dragItems[i].getAttribute('y')) + parseInt($dragPad.top);
                            if(active){
                                $('#dragPad').append('<div value="'+value+'" class="dragItem hidden" style="position:absolute; top:'+parseInt($dragPad.top+$dragPadcenter)+'px; left:'+parseInt($dragPad.left+$dragPadcenter)+'px; padding:10px; border:2px solid black" x="'+x+'" y="'+y+'">'+value+'</div>');
                            }
                        }
                    }
                });
                $('#dragPad').on('click', function(){
                    $('.dragItem').removeClass('hidden');
                    $('.dragItem').each(function(){
                        $(this).animate({
                            left: $(this).attr('x'),
                            top: $(this).attr('y'),
                            opacity: "1"
                        }, "slow");
                    });
                });
                $(document).on('click', '.dragItem', function(){
                    $pass.push($(this).attr('value'));
                    $(this).animate({
                        left: parseInt($dragPad.left+$dragPadcenter),
                        top: parseInt($dragPad.top+$dragPadcenter),
                        opacity: "0"
                    }, "slow");
                });
                $('#dragPad').on('dblclick', function(){
                    $pass = $('#code').val();
                    $.ajax({
                        url: "<?= routeTo("/public/android/dragPattern.xml") ?>",
                        method: 'GET',
                        success: function(DATA){
                            var $correct = DATA
                                    .getElementsByTagName('dragItems')[0]
                                    .getElementsByTagName('currentPassword')[0]
                                    .childNodes[0]
                                    .nodeValue;
                            var $p = $pass.join('');
                            if($p === $correct){
                                alert('Password is correct!');
                            }else{
                                alert('Password is INCORRECT!!');
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
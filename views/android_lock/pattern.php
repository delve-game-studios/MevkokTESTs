<html>
        <link rel="stylesheet" href="<?= routeTo("/public/css/jquery-ui.css") ?>">
        <link rel="stylesheet" href="<?= routeTo("/public/css/style.css") ?>">
        <script src="<?= routeTo("/public/js/jquery-1.10.2.js") ?>"></script>
        <script src="<?= routeTo("/public/js/jquery-ui.js") ?>"></script>
    <!--<script src="http://d3lp1msu2r81bx.cloudfront.net/kjs/js/lib/kinetic-v5.0.1.min.js"></script>-->
    <script defer="defer"></script>
    <?php
    $circle_s = '50px';
    if(!isset($_REQUEST['gsize'])){
        $circle_size = $circle_s;
    }else{
        $circle_size = $_REQUEST['gsize'];
    }
    ?>
    <style>
        *{
            -webkit-user-select: none; 
        }
        table{
            margin: 0 auto;
            margin-top: 10px;
        }
        #numPad{
            border: 3px solid black;
            border-radius: 10px;
        }
        div, .num{
            border: 5px solid black;
            border-radius: <?= $circle_size ?>;
            background: white;
            font-size: 20px;
            padding: <?= $circle_size ?>;
        }
        input[type=text],input[type=password]{
            height: 33px;
            font-size: 20px;
            text-align: center;
        }
        #codeTable{
            display: none;
        }
    </style>
    <table id="numPad" border="0" width="2" cellspacing="1" cellpadding="20">
        <tbody>
            <tr>
                <td>
                    <div class="num" value="1" name="1" >1</div>
                </td>
                <td>
                    <div class="num" value="2" name="2" >2</div>
                </td>
                <td>
                    <div class="num" value="3" name="3" >3</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="num" value="4" name="4">4</div>
                </td>
                <td>
                    <div class="num" value="5" name="5" >5</div>
                </td>
                <td>
                    <div class="num" value="6" name="6" >6</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="num" value="7" name="7" >7</div>
                </td>
                <td>
                    <div class="num" value="8" name="8" >8</div>
                </td>
                <td>
                    <div class="num" value="9" name="9" >9</div>
                </td>
            </tr>
        </tbody>
    </table>
    <table id="codeTable" border="2" width="2" cellspacing="1" cellpadding="25">
        <tr>
            <td>
                <input size="25" id="codeField" type="text" name="code" value="" placeholder="Code" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <th>
                <input type="div" id="confirm" value="Confirm"><input type="div" id="reset" value="Reset"><input type="div" id="cancel" value="Cancel">
                <script>
                    $(document).ready(function(){
                        
                    });
                </script>
            </th>
        </tr>
    </table>
    <script>
        $(document).ready(function(){
            var password = '147258369';
            var mousedown = false;
            $('#reset').on('click', function(){
                $('#codeField').val('');
                $('div').removeAttr('disabled');
                $('div').removeAttr('style');
                mousedown = false;
                $('#numPad').attr('style','border-color:black;');
            });
            $('#numPad').mousedown(function(){
                mousedown = true;
            });
            $('#numPad').dblclick(function(){
                $('#reset').click();
            });
            $('*').mouseup(function(){
                mousedown = false;
                if($('*.num').attr('disabled') === 'disabled'){
                    if($('#codeField').val() === password){
                        $('#numPad').attr('style','border-color:lime;');
                    }else{
                        $('#numPad').attr('style','border-color:red;');
                    }
                }
            });
            $('div').on('mouseover',function(){
                if(mousedown === true){
                    var currentCode = $('#codeField').val();
                    this.setAttribute('disabled','disabled');
                    this.setAttribute('style','border-color: lime;');
                    $('#codeField').val(currentCode+this.value);
                }else{
                    return false;
                }
             });
        });
    </script>
</html>
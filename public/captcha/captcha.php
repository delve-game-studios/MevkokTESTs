<?php
    
     session_start(); 
    
     //Now lets use md5 to generate a totally random string
     $md5 = md5(microtime() * time());
     
     /*
     We dont need a 32 character long string so we trim it down to 5
     */
     $string = substr($md5,0,5);
     
     /*
     Now for the GD stuff, for ease of use lets create the image from a background image.
     */
     
     $captcha = imagecreatefrompng("./captcha.png"); 
     
     /*
        Lets set the colours, the colour $line is used to generate lines.
        Using a blue misty colours. The colour codes are in RGB
     */
     
     $black = imagecolorallocate($captcha, 0, 0, 0);
     $line = imagecolorallocate($captcha,233,239,239);

     /*
        Now to make it a little bit harder for any bots to break, 
        assuming they can break it so far. Lets add some lines
        in (static lines) to attempt to make the bots life a little harder
     */
     imageline($captcha,0,0,39,29,$line);
     imageline($captcha,40,0,64,29,$line);
     
     /*
        Now for the all important writing of the randomly generated string to the image.
     */
     imagestring($captcha, 5, 50, 10, $string, $black);
     
     /*
     Output the image
     */
     
     $_SESSION['captcha'] = md5($string); 
     
     header("Content-type: image/png");
     imagepng($captcha);
     imagedestroy($captcha);
?>

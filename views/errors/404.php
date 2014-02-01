
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
        <title>Error 404 - Page Not Found</title> 

        <link rel="icon" href="/favicon.ico" type="image/x-icon" /> 
        <link rel="shortcut icon" href="/favicon.ico"  type="image/x-icon" /> 
        <!-- This page, code and content is copyrighted material owned by Martin Korner. --><style type="text/css">/*
         # # You do not have any right to copy, use or edit this page for any purposes.
         # # You can, however, purchase rights to use the error page on your site - just email enquiries@martinkorner.co.uk for costs.
         # # For further legal details, please visit www.martinkorner.co.uk/legal.htm */

            body {background:#4a8ad3 url(<?php echo routeTo('/public/error/404.jpg') ?>); font-family:Arial, Helvetica, sans-serif; color:#000; font-size:16px;}

            #position {position:absolute; bottom:0px; right:0px; padding:10px; width:45em; height:16em; color:#fff;}
            #background {position:absolute; bottom:2em; right:0px; padding:10px; width:45em; height:14em; background:#274fae; filter:alpha(opacity=50); -moz-opacity:0.5; opacity:0.5; border-style:double none double double; border-color:#07286f; border-width:3px;}

            a:link {color:#000099; text-decoration:none;}
            a:visited {color:#000066; text-decoration:none;}
            a:hover {color:#000099; text-decoration:underline;}

            .h1 {font-size:24px; color:#fff; text-align:left; max-width:25em; font-weight:bold; padding-top:15px;}
            .h1 div {text-align:right;}
            h3 {text-align:center; font-size:18px;}

            .copyright {position:absolute; right:0px; bottom:0px; font-size:10px; color:#14336f}

            .statcounter {display:none;}
        </style> 



    </head> 

    <body> 


        <!-- output: external --> 
        <!-- sendEmail:  --> 


        <div id="background"></div> 

        <div id="position"> 
            <div class="h1">ERROR 404: NOT FOUND</div>
            <div class="h1">The page you were looking for appears to<div>have been moved, deleted or does not exist.</div>
                
        </div> 

            <ul> 

                <li>I have been notified about this error and will notify the webmaster of <?php echo $_SERVER['HTTP_HOST'] ?> about it as soon as possible.</li><ul><li>You tried to reach a page via a link from <b><?php echo $_SERVER['HTTP_HOST'] ?></b>.</li></ul> 

                <li>Try returning to the <a href="<?php echo routeTo('/') ?>">home page</a> and finding the page you were looking for.</li> 
            </ul> 


            <h3>Sorry for your inconvenience</h3> 
        </div>

        <div class="copyright"></div> 

    </body> 
</html> 
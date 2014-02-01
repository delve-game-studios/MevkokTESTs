<?php
/**
 * <p>Performs a page redirect action.</p>
 * @param string $path The route to the controler and action ':controller/:action' or an already set route from config/routes
 * @param array $flash[optional] You can send a message to the page (array('notice'=>'Hello world'))
 */
function redirectTo($path,array $flash=null) {
    if($flash) {
        foreach($flash as $variable=>$message) {
            flash($variable, $message);
        }
    }

    header('location: ' . AppPath.$path);
    exit;
}

/**
 * <p>Generates route for the current application</p>
 * @param string $route route to action
 * @return string the url path
 */
function routeTo($route) {
    return AppPath . $route;
}

/**
 * <p>Set and display messages anywhere in your application</p>
 * @param string $variable The variable name like 'notice' or 'error'
 * @param string $message[Optional] Message to be send
 * @return Mixed Null on setting the message and the message on displaying.
 * @example
 * <p>Setting a message: flash('notice','Hello world');</p>
 * <p>Displaying the message: flash('notice'); ==> Hello world</p>
 */
function flash($variable, $message=null) {
    if($message) {
        $_SESSION[$variable]=$message;
        return null;
    }else {
        $flash = null;
        if(isset($_SESSION[$variable])) {
            $flash = $_SESSION[$variable];
            unset ($_SESSION[$variable]);
        }

        return $flash;
    }
}

 /**
 * <p>Protect from forgery </p>
 * @return Function return input hidden field and save the value in session variable
 */

 function protectFromForgery()
 {
    if(!isset($_SESSION['protect_form']))
    {
        $value = md5(uniqid(rand(), TRUE));

        $_SESSION['protect_form'] = $value;
    }
    return '<input type="hidden" value="'.$_SESSION['protect_form'].'" name="protect_from_forgery"/>';
 }

/**
 * <p>Converts chars to lower and generate frendly url</p>
 * @param string $text The text to be converted
 * @return string $fid The converted text
 */
function friendlyName($text)
{
    $fid = trim($text);

    $fid = mb_strtolower($text,'utf-8');

    $search = array(' - ','?',' ','!',',','(',')','/','\\','"',"'",'&','+','„','“','.');
    $replace = array('-','','_','','','','','','','','','','_','','','_');

    $fid = str_ireplace($search,$replace,$fid);

    return $fid;
}

 /**
  * Outputs the a given variable. If the variable is not previously set it will be set on function call.
  * @param Mixed $variable The variable that will be printed.
  * @param bool $sanitize Default value is true. If set to true it will sanitize the string for html.
  * @param bool $debug Default value false. If set to true the function will dump the variable for debugging.
  * @return Mixed
  */
function out(&$variable, $sanitize = true, $debug = false) {
    if($debug) {
        var_dump($variable);
    } else {
        if($sanitize) {
            return htmlspecialchars($variable);
        } else {
            return $variable;
        }
    }
}
?>

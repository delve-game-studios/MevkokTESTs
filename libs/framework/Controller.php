<?php
/*
 *
 *
 * Copyright (c) 2010 158, Ltd.
 * All Rights Reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification are not permitted.
 *
 * Neither the name of 158, Ltd. or the names of contributors
 * may be used to endorse or promote products derived from this software
 * without specific prior written permission.
 *
 * This software is provided "AS IS," without a warranty of any kind. ALL
 * EXPRESS OR IMPLIED CONDITIONS, REPRESENTATIONS AND WARRANTIES, INCLUDING
 * ANY IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE OR NON-INFRINGEMENT, ARE HEREBY EXCLUDED. 158 AND ITS LICENSORS
 * SHALL NOT BE LIABLE FOR ANY DAMAGES SUFFERED BY LICENSEE AS A RESULT OF
 * USING, MODIFYING OR DISTRIBUTING THE SOFTWARE OR ITS DERIVATIVES. IN NO
 * EVENT WILL 158 OR ITS LICENSORS BE LIABLE FOR ANY LOST REVENUE, PROFIT
 * OR DATA, OR FOR DIRECT, INDIRECT, SPECIAL, CONSEQUENTIAL, INCIDENTAL OR
 * PUNITIVE DAMAGES, HOWEVER CAUSED AND REGARDLESS OF THE THEORY OF
 * LIABILITY, ARISING OUT OF THE USE OF OR INABILITY TO USE SOFTWARE, EVEN
 * IF 158 HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 *
 * Any violation of the copyright rules above will be punished by the lay.
 */

/*
 * Controller class controls the website's temlate
 */

class Controller {

    /**
     *
     * <b>@layout string </b>
     * <p>The variable contains the application layout name.</p>
     * <p>You can set the layout name from the controller action. When the render method is executed in the action, it will load the layout from views/layouts/<layout_name>.php</p>
     */
    protected $layout = 'default';

    /**
     *
     * <b>@content string</b>
     * <p>This variable contains the html result from executing an action and it's view</p>
     */
    protected $content = null;
    
    /**
     * Contains the ActionFilter's object
     * @var ActionFilter 
     */
    private $filter;
    
    /**
     * Creates an instance of Controller 
     */
    function __construct() {
        $this->filter = new ActionFilters($this);
    }

    public function __destruct() {

    }
    
    /**
     * Gets the ActionFilters' object
     * @return ActionFilters 
     */
    public function filter() {
        return $this->filter;
    }

    /**
     *
     * <p>renderPage method renders the complete html for the page</p>
     */
    protected function renderPage() {//generates the the html code of the page
        ob_start();
        include DocumentRoot . '/views/layouts/' . $this->layout . '.php';
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * Sets the layout used for rendering views
     * @param type $name
     */
    protected function setTemplate($name) {
        $this->layout = $name;
    }

    /**
     * <p>Renders a view for the coresponding action.</p>
     * @param string $view - the path to the view file that coresponds to the current action ('applications/index.php')
     * @param bool $layout  - Is optional. If true renders the view with the given layout. If false renders only the view
     * @param bool $absolute_path  - Is optional. If true renders the view from an absolute path to the file.
     */
    public function render($view, $layout = true, $absolute_path = false) {
        $content = $this->getView($view, $absolute_path);

        if ($layout) {
            $this->content = $content;
            echo $this->renderPage();
        } else {
            echo $content;
        }
    }
    
    /**
     * <p>Loads a view for the coresponding action and returns the result as a string.</p>
     * @param string $view - the path to the view file that coresponds to the current action ('applications/index.php')
     * @param bool $absolute_path  - Is optional. If true renders the view from an absolute path to the file.
     * @return string interpreted view
     */
    public function getView($view, $absolute_path = false) {
        ob_start();
        if ($absolute_path) {
            include $view;
        } else {
            include DocumentRoot . '/views/' . $view;
        }
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    }

    /**
     * Renders a partial view file.
     * @param string $view the path to the view file ('applications/index.php')
     * @param bool $absolute_path Is optional. If true renders the view from an absolute path to the file.
     */
    public function renderPartial($view, $absolute_path = false) {
        
        $this->render($view, false, $absolute_path);
    }


    /**
     * Executes a given action from a given controller
     * @param controller $controller The name of the controller
     * @param string $action The name of the action
     * @param array $params An array with parameters
     * @return mixed The output from execution of the controller's action
     */
    public static function renderComponent($controller, $action, array $params = array()) {
        if (file_exists('controllers/' . $controller . '.php')) {
            require_once 'controllers/' . $controller . '.php';
        }

        $controllObject = new $controller();
        ob_start();
        call_user_func_array(array($controllObject, $action), $params);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     * Renders the default page 404
     */
    public function pageNotFound() {
        $this->render('errors/404.php', false);
    }

    /**
     * Renders the default page 500
     */
    public function internalError() {
        $this->render('errors/500.php', false);
    }

    /**
     * Renders an object to a json content type.
     * @param Mixed $object The object that will be encoded in json format
     */
    public static function renderJson($object) {
        header('Content-type: application/json');
        echo json_encode($object);
    }

}

?>

<?php

/*
 */

class Route {

    /**
     *
     * @var string $route
     * <div>Contains a list of routes</div>
     */
    static $route;

    /**
     * <b>Executes the route givent to index.php</b>
     * <p>Checks if it exists in the route list and executes the coresponding controller and action</p>
     * <p>If it does not exist in the list - tries to execute according to :controller/:action</p>
     * <p>If the route does not match any of the above specs, the script returns '404 not found' header</p>
     */
    static function executeRoute() {
        $_SERVER['REQUEST_URI'] = preg_replace('/\?.*$/is', '', $_SERVER['REQUEST_URI']);

        $route_path = preg_replace('/^'.preg_quote(AppPath, '/').'/i', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if (!$route_path)
            $route_path = '/';

        $segments = Route::urlEval($route_path);

        $application = new Application();

        $controller = null;
        $action = null;

        if ($segments) {
            if($segments['controller'] != 'Application') {
                if (file_exists('controllers/' . $segments['controller'] . '.php')) {
                    require_once 'controllers/' . $segments['controller'] . '.php';
                }
            }

            if (class_exists($segments['controller'])) {
                $controllerObject = null;
                if($segments['controller'] != 'Application') {
                    $controllerObject = new $segments['controller']();
                } else {
                    $controllerObject = $application;
                }

                if (is_subclass_of($controllerObject, 'Controller')) {
                    $controller = $controllerObject;
                    unset ($controllerObject);

                    if (method_exists($controller, $segments['action'])
                            && is_callable(array($controller, $segments['action']))) {
                        $action = $segments['action'];
                    }
                }
            }
        }

        if(is_null($controller) || is_null($action)) {
            // Exec before filters
            $application->filter()->before();
            // Exec action
            $application->pageNotFound();
            // Exec after filters
            $application->filter()->after();
        } else {
            // Exec before filters
            $controller->filter()->before();
            // Exec action
            $controller->$action();
            // Exec after filters
            $controller->filter()->after();
        }
    }

    private static function urlSegmentation($path) {
        $segments = explode('/', $path);
        unset($segments[0]);

        return $segments;
    }

    private static function urlEval($path) {
        $segments = false;

        foreach (Route::$route as $key => $execution) {
            if (preg_match('@^' . preg_replace('/:[^\/]+/i', '[^\/]+', $key) . '(\/|)$@i', $path)) {

                $segments = $execution;

                $route_segments = Route::urlSegmentation($key);
                $path_segments = Route::urlSegmentation($path);
                foreach ($route_segments as $val) {
                    if (is_integer(strpos($val, ':')) && strpos($val, ':') == 0) {
                        $segments[str_ireplace(':', '', $val)] = current($path_segments);
                    }
                    next($path_segments);
                }
                break;
            }
        }
        if ($segments) {

            $_REQUEST = array_merge($_REQUEST, $segments);
        }
        return $segments;
    }
    
    /**
     * Retrieves an array of routes that match a specific description
     * @param type $controller Controller name
     * @param type $action Action name
     * @param array $urlParams Url parameters that can be binded to a value
     * @return boolean an array of all the matching routes or false on fail
     */
    static function routesFor($controller, $action, array $urlParams = array()) {
        $routes = array_keys(self::$route, array('controller' => $controller, 'action' => $action));
        if(count($urlParams) > 0) {
            $matchingRoutes = array();
            foreach($routes as $route) {
                $regex = '';
                foreach($urlParams as $key => $param) {                    
                    if(count($urlParams) - 1 == $key) {
                        $regex .= '[^\:]+'.preg_quote(':'.$param, '/');
                    } elseif($key == 0) {
                        $regex .= preg_quote(':'.$param, '/');
                    } else {
                        $regex .= '[^\:]+'.preg_quote(':'.$param, '/');
                    }
                }
                
                if(preg_match("/$regex/", $route)) {
                    $matchingRoutes[] = $route;
                }
            }
            
            return $matchingRoutes;
        } else {
            return $routes;
        }
        
        return false;
    }
    
    /**
     * Finds the route that coresponds to a given controller and action pair and builds an url
     * @param string $controller Controller name
     * @param string $action Action name
     * @param array $params parameters to bind to the route
     * @return boolean String if an url can be build or false on fail
     */
    static function buildUrl($controller, $action, array $params) {
        $route = current(self::routesFor($controller, $action, array_keys($params)));
        if(!$route) {
            return false;
        }
        
        foreach($params as $param => $val) {
            $route = preg_replace('/'.preg_quote(':'.$param).'/', $val, $route);
        }
        
        return $route;
    }

}

?>

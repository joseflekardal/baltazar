<?php

require_once __DIR__ . '/controllers/Controller.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/init.php';

class App
{
    private static $routes = [];
    private static $regxs = [
        ':num'  => '[0-9]+',
        ':any'  => '',
        ':all'  =>  '.*'
    ];

    public static function __callStatic($method, $params)
    {
        foreach(self::$regxs as $regx => $val) {
            if (strpos($params[0], $regx)) {
                $params[0] = str_replace($regx, $val, $params[0]);
            }
        }
        array_push(static::$routes, [
            'method'    => $method,
            'uri'       => $params[0],
            'action'    => $params[1]
        ]);
    }

    static function dispatch()
    {
        // CHECK HTTP METHOD

        // none dynamic route
        foreach(self::$routes as $route) {
            if ($route['uri'] == $_GET['url']) {
                return $route['action']();
            }
        }

        // dynamic route
        foreach(self::$routes as $route) {
            if (preg_match_all('#' . $route['uri'] . '#', $_GET['url'])) {
                $segments = explode('/', $_GET['url']);
                $route_split = explode('/', $route['uri']);

                $args = [];
                foreach (self::$regxs as $regx) {
                    $matches = array_keys($route_split, $regx);
                    foreach($matches as $index) {
                        array_push($args, $segments[$index]);
                    }
                }

                if (is_string($route['action'])) {
                    // Controller and method like: Controller\MyController@index
                    // Explode on @
                    // instantiate: $controller = new Controller()
                    // method exists: method_exists($controller, method)
                    // return call_user_func_array([controller, method], $args);
                }
                return call_user_func_array($route['action'], $args);
            }
        }
        http_response_code(404);
        echo "404 page not found";
    }

}
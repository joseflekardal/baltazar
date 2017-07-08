<?php

class App
{
    private static $controller = null;
    private static $method = null;
    private static $args = [];
    private static $callable = [];
    private static $routes = [];
    private static $regxs = [
        ':num'  => '([0-9]+)',
        ':any'  => '([^/]+)',
        ':all'  => '(.*)'
    ];

    public static function __callStatic($method, $params)
    {
        $uri = trim($params[0], '/');
        $action = $params[1];
        $middleware = $params[2] ?? null;

        foreach (static::$regxs as $regx => $val) {
            if (strpos($uri, $regx) !== false) {
                $uri = str_replace($regx, $val, $uri);
            }
        }

        array_push(static::$routes, [
            'method'        => strtoupper($method),
            'uri'           => $uri,
            'action'        => $action,
            'middleware'    => $middleware
        ]);
    }

    public static function run()
    {
        $http_method = $_SERVER['REQUEST_METHOD'];
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';

        $matches = array_filter(static::$routes, function($r) use ($url, $http_method) {
            if ($r['uri'] === $url && $r['method'] === $http_method) {
                return true;
            } elseif (preg_match_all('#' . $r['uri'] . '$#', $url, $preg_results) && ! empty($r['uri']) && $r['method'] === $http_method) {
                array_shift($preg_results);
                array_push(static::$args, array_map(function($match) {
                    return $match[0];
                }, $preg_results));
                return true;
            }
            return false;
        });


        if (empty($matches)) {
            echo "404 page not found";
            return http_response_code(404);
        }

        $match = array_shift($matches);
        
        if (static::$args) {
            static::$args = static::$args[0];
        }

        if (is_string($match['action'])) {
            $segments = explode('@', $match['action']);
            static::$controller = new $segments[0]();

            if (method_exists(static::$controller, end($segments))) {
                static::$callable = [static::$controller, end($segments)];
            }
        } else {
            static::$callable = $match['action'];
        }

        if ($match['middleware']) {
            call_user_func('Baltazar\Middleware\Middleware::' . $match['middleware']);
        }
 
        return call_user_func_array(static::$callable, static::$args);
    }

}
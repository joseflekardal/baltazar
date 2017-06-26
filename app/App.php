<?php

require_once __DIR__ . '/controllers/Controller.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/init.php';

class App
{
    private $controller = 'home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url_params = $this->parse_url($_GET['url'] ?? '');
        
        if (isset($url_params[0]) && file_exists(__DIR__ . '/controllers/' . $url_params[0] . '.php')) {
            $this->controller = $url_params[0];
            unset($url_params[0]);
        }

        require __DIR__ . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url_params[0]) && method_exists($this->controller, $url_params[0])) {
            $this->method = $url_params[0];
            unset($url_params[0]);
        }

        $this->params = $url_params;
    }

    private function parse_url(string $query_string)
    {
        return array_filter(
            explode('/', rtrim(
                filter_var(
                    $query_string, FILTER_SANITIZE_STRING)
                )
            )
        );
    }

    public function run()
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

}
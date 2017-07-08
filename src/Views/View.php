<?php namespace Baltazar\Views;

class View
{   
    public static function render(string $name, array $resources = [])
    {
        extract($resources);

        if (! file_exists(__DIR__ . "/{$name}.php")) {
            die('Couldn\'t find this page');
        }
        require_once $name . '.php';
    }

    public static function render_json(array $resources = [])
    {
        echo json_encode($resources);
    }
}
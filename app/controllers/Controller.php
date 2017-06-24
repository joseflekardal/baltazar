<?php

abstract class Controller
{
    protected function render($resources)
    {
        extract($resources);
        require __DIR__ . '/../views/' . get_called_class() . '.php';
    }

    protected function render_json($resources)
    {
        echo json_encode($resources);
    }


}
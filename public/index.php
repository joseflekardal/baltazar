<?php

require_once '../vendor/autoload.php';
require_once '../app/App.php';

App::get('', function() {
    echo "Welcome to index";
});

App::get('testroute/:num', 'Lekardal\Post@index');

App::get('normal/route', function() {
    echo "Hello this is home!";
});

App::get('api/:num/hello/:all', function($id, $num) {
    echo "hello/:num is working. {$id} {$num}";
});

App::dispatch();
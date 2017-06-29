<?php

require_once '../vendor/autoload.php';
require_once '../src/App.php';

$app = new App;

$app->get('api/post/:num', 'Post@index');

$app->get('client', function() {
    require_once __DIR__ . '/../client/index.html';
});

$app->get('api/:num/hello/:all', function($id, $name) {
    echo "Arguments in any order:<br>id: {$id}<br>name: {$name}";
});

$app->dispatch();
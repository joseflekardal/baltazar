<?php

require_once '../vendor/autoload.php';
require_once '../src/App.php';

$app = new App;

$app->get('', 'Home@index');
$app->get('api/posts', 'Post@index');
$app->get('user/:num', 'User@index');
$app->get('client', function() {
    require_once __DIR__ . '/../client/index.html';
});

$app->post('newpost', 'Post@create');

$app->dispatch();
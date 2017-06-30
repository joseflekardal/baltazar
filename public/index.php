<?php

require_once '../vendor/autoload.php';
require_once '../src/App.php';

App::get('', 'Home@index');
App::get('api/posts', 'Post@index');
App::get('user/:num', 'User@index');
App::get('client', function() {
    require_once __DIR__ . '/../client/index.html';
});
App::get(':all/:num/:any', function($p1, $p2, $p3) {
    echo "Hello from :all, this is the param: {$p1} {$p2} {$p3}";
});

App::post('newpost', 'Post@create');

App::get('test/:num/:num', function($num1, $num2) {
    echo "Hello from test/:num/:num {$num1} {$num2}";
});

App::get('test', function() {
    echo "Hello from test";
});

App::post('test', function() {
    echo 'Hello POST';
});


App::dispatch();
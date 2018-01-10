<?php

use Baltazar\Views\View;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';

App::get('/', 'Baltazar\Controllers\HomeController@index');
App::get('/post/:num', 'Baltazar\Controllers\PostController@index');
App::get('/user/:num', 'Baltazar\Controllers\UserController@index');

App::get('josef/:any/:any', function($first, $last) {
  echo "Josef {$last} {$first}";
});

App::run();

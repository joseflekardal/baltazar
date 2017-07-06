<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';

App::get('/api/v1/users', 'UserController@all');

App::post('/api/v1/users', 'User@create');
App::get('/api/v1/users/:num', 'UserController@index');
App::put('/api/v1/users/:num', 'User@update');
App::delete('/api/v1/users/:num', 'User@delete');

App::get('/:all', function() {
    require_once __DIR__ . '/../client/index.html';
});

App::run();
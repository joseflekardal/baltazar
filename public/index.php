<?php

use Baltazar\Views\View;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';

App::get('/api/v1/users', 'Baltazar\Controllers\UserController@all');
App::get('/api/v1/tweets', 'Baltazar\Controllers\TweetController@all');
App::get('/api/v1/users/:num', 'Baltazar\Controllers\UserController@index');

App::post('/api/v1/users', 'Baltazar\Models\User@create');
App::post('/api/v1/likes', 'Baltazar\Models\Like@create');

App::put('/api/v1/users/:num', 'Baltazar\Models\User@update');

App::delete('/api/v1/users/:num', 'Baltazar\Models\User@delete');
App::delete('/api/v1/likes', 'Baltazar\Models\Like@delete');

App::get('/search', function() {
    require_once __DIR__ . '/../client/search.php';
});

App::get('/:all', function() {
    require_once __DIR__ . '/../client/index.php';
});

App::run();
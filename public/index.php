<?php

require_once '../app/App.php';

App::get('normal/route', function() {
    echo "Hello this is home!";
});

App::get('api/:num/hello/:num', function($id, $num) {
    echo "hello/:num is working. {$id} {$num}";
});

App::dispatch();
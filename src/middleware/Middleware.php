<?php namespace Baltazar\Middleware;

class Middleware
{
    public static function token_protected()
    {
        if (!isset($_GET['token']) || $_GET['token'] !== 'whatupbro') {
            die('You don\'t have access, please provide a valid token');
        }
    }

    public static function basic_auth()
    {
        if (! isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die('Please provide username and password');
        } else {
            echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
            echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
        }
    }
}
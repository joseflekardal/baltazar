<?php namespace Lekardal;

use Lekardal\Controller;

class User extends Controller
{
    public function __construct()
    {
    }

    public function index($first_name = '', $last_name = '')
    {
        echo "Hello from index {$first_name}";
    }
}

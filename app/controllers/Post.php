<?php namespace Lekardal;

use Lekardal\Controller;

class Post extends Controller
{
    public function __construct()
    {
    }

    public function index($id)
    {
        echo "Hi from Post@index id: {$id}";
    }
}

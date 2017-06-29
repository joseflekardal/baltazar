<?php namespace Lekardal;

use Lekardal\Controller;

class Home extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        echo "This is " . get_class($this);
    }
}
<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;

class HomeController
{
    public function index()
    {
        return View::render('home');
    }
}

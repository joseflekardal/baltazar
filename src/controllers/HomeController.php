<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;
use Baltazar\Models\Post;

class HomeController
{
    public function index()
    {
        $post = new Post();
        return View::render('home', ['posts' => $post->all()]);
    }
}

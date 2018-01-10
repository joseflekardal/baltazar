<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;
use Baltazar\Models\Post;

class PostController
{
    public function index($id)
    {
        $post = new Post();
        View::render('post', ['post' => $post->find($id)]);
    }

    public function all()
    {
        $post = new Post();
        View::render('home', ['posts' => $post->all()]);
    }
}

<?php

class Post extends Controller
{
    public function __construct()
    {
    }

    public function index($id)
    {
        $post = new PostModel();
        $this->render_json([
            'posts' => $post->all()
        ]);
    }
}
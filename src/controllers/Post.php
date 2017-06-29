<?php

class Post extends Controller
{
    public function index()
    {
        $post = new PostModel();
        $this->render_json([
            'posts' => $post->all()
        ]);
    }
}
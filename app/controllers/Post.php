<?php

require_once __DIR__ . '/../models/PostModel.php';

class Post extends Controller
{
    public function __construct()
    {
    }

    public function index($id)
    {
        $post = new PostModel();

        $this->render_json($post->find($id));
    }
}

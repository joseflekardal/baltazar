<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;
use Baltazar\Models\{Tweet, Like};

class TweetController
{
    public function index($id)
    {
        $tweet = new Tweet();
        View::render_json([
            'tweets' => $tweet->find($id)
        ]);
    }

    public function all()
    {
        $tweet = new Tweet();
        $like = new Like();
        View::render_json([
            'tweets' => $tweet->all(),
            'likes' => $like->all()
        ]);
    }
}
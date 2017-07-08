<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;
use Baltazar\Models\User;

class UserController
{
    public function index($id)
    {
        $user = new User();
        View::render_json(['user' => $user->find($id)]);
    }

    public function all()
    {
        $user = new User();
        View::render_json(['users' => $user->all()]);
    }
}

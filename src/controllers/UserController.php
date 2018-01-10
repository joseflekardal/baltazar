<?php namespace Baltazar\Controllers;

use Baltazar\Views\View;
use Baltazar\Models\User;

class UserController
{
    public function index($id)
    {
        $user = new User();
        View::render('user', ['user' => $user->find($id)]);
    }
}

<?php

require_once __DIR__ . '/../models/UserModel.php';

class User extends Controller
{
    public function __construct()
    {
    }

    public function index($first_name = '', $last_name = '')
    {
        $user = new UserModel();

        $users = $user->all();

        $this->render(['users' => $users]);
    }
}

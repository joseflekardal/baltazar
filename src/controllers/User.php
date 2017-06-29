<?php

class User extends Controller
{
    public function index($id)
    {
        $user = new UserModel();
        $this->render([
            'user' => $user->find($id)
        ]);
    }
}

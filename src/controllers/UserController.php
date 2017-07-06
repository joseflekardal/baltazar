<?php

class UserController extends Controller
{
    public function index($id)
    {
        $user = new User();
        $this->render_json([
            'user' => $user->find($id)
        ]);
    }

    public function all()
    {
        $user = new User();
        $this->render_json([
            'users' => $user->all()
        ]);
    }
}

<?php namespace Baltazar\Models;

use Baltazar\Models\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        $json = file_get_contents('php://input');
        $user = json_decode($json, TRUE);

        $sth = $this->db->prepare("INSERT INTO users
            (username, first_name, last_name, email, password)
            VALUES
            (:username, :first_name, :last_name, :email, :password)"
        );

        $data = [
            ':username'     => (string) $user['username'],
            ':first_name'   => (string) $user['first_name'],
            ':last_name'    => (string) $user['last_name'],
            ':email'        => (string) $user['email'],
            ':password'     => (string) password_hash($user['email'], PASSWORD_DEFAULT)
        ];

        if (! $sth->execute($data)) {
            die('Couldn\'t create user');
        }

        echo "User created";
    }

}
<?php

class UserModel extends Model
{
    protected $table = 'users';
    protected $sql = 'SELECT
        users.*,
        CONCAT(users.first_name, " ", users.last_name) AS "full_name"
        FROM users';

    public function __construct()
    {
        parent::__construct();
    }
}
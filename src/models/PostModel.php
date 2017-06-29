<?php

class PostModel extends Model
{
    protected $table = 'posts';
    protected $sql = 'SELECT
        posts.*,
        categories.name,
        CONCAT(users.first_name, " ", users.last_name) "author"
        FROM posts
        JOIN users ON posts.user_id = users.id
        JOIN categories ON posts.cat_id = categories.id';

    public function __construct()
    {
        parent::__construct();
    }

}
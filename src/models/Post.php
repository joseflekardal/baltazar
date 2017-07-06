<?php

class Post extends Model
{
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

    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO posts
                (user_id, title, content)
                VALUES (:user_id, :title, :content)
            ");

            $stmt->execute([
                ':user_id'  => (int) $_POST['user_id'],
                ':title'    => (string) $_POST['title'],
                ':content'  => (string) $_POST['content']
            ]);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}
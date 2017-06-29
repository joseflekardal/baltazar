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

    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO posts
                (user_id, title, content)
                VALUES (:user_id, :title, :content)
            ");

            $stmt->bindValue(':user_id', $_POST['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $_POST['content'], PDO::PARAM_STR);

            $stmt->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}
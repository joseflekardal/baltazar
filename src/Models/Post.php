<?php namespace Baltazar\Models;

use Baltazar\Models\Model;
use \PDO;

class Post extends Model
{
    protected $sql = 'SELECT
        posts.*,
        CONCAT(users.first_name, " ", users.last_name) AS "author",
        users.id AS "author_id"
        FROM posts
        JOIN users ON posts.user_id = users.id';

    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO posts
                (user_id, title, body)
                VALUES (:user_id, :title, :body)
            ");

            $stmt->execute([
                ':user_id'  => (int) $_POST['user_id'],
                ':title'    => (string) $_POST['title'],
                ':body'     => (string) $_POST['body']
            ]);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}

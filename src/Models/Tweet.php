<?php namespace Baltazar\Models;

use Baltazar\Models\Model;

class Tweet extends Model
{
    protected $sql = 'SELECT
        tweets.*,
        CONCAT(users.first_name, " ", users.last_name) AS "author"
        FROM tweets
        JOIN users ON tweets.user_id = users.id';

    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tweets
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
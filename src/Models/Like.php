<?php namespace Baltazar\Models;

use Baltazar\Models\Model;

class Like extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        $json = file_get_contents('php://input');
        $like = json_decode($json, TRUE);

        $sth = $this->db->prepare("INSERT INTO likes
            (tweet_id, user_id)
            VALUES
            (:tweet_id, :user_id)");

        $sth->execute([
            ':tweet_id' => $like['tweet_id'],
            ':user_id'  => $like['user_id']
        ]);

        echo "Like added";
    }

    public function delete(int $id = 0)
    {
        $json = file_get_contents('php://input');
        $like = json_decode($json, TRUE);

        $sth = $this->db->prepare("DELETE FROM likes
            WHERE user_id = :user_id
            AND tweet_id = :tweet_id");

        $sth->execute([
            ':tweet_id' => $like['tweet_id'],
            ':user_id'  => $like['user_id']
        ]);

        echo "Like removed";

    }
}
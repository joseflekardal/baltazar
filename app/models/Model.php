<?php

class Model
{
    protected $db;
    protected $table;
    protected $sql;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->table = $this->table ?? strtolower(get_called_class()) . 's';
        $this->sql = $this->sql ?? "SELECT * FROM {$this->table}";
    }

    public function all()
    {
        return $this->db->query($this->sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function find($id)
    {
        $sth = $this->db->prepare("{$this->sql} WHERE {$this->table}.id = :id");
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();

        if (! $result = $sth->fetch(PDO::FETCH_OBJ)) {
            http_response_code(404);
            die;
        }
        return $result;
    }

}
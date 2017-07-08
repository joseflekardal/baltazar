<?php namespace Baltazar\Models;

use \PDO;

require_once __DIR__ . '/../config.php';

class Model
{
    protected $db;
    protected $table;
    protected $sql;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME. ';charset=utf8', DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $this->table = $this->table ?? $this->get_table_name();
            $this->sql = $this->sql ?? "SELECT * FROM {$this->table}";
        } catch(PDOException $e) {
            die('Not connected');
        }	
    }

    private function get_table_name()
    {
        $namespace_parts = explode('\\', get_called_class());
        $class_name = end($namespace_parts);
        $table_name = strtolower($class_name) . 's';
        return $table_name;
    }

    public function all()
    {
        return $this->db
            ->query($this->sql)
            ->fetchAll(PDO::FETCH_OBJ);
    }

    public function find(int $id)
    {
        $sth = $this->db->prepare("{$this->sql} WHERE {$this->table}.id = :id");
        $sth->execute([':id' => $id]);

        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function delete(int $id)
    {
        $sth = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");

        if (! $sth->execute([':id' => $id])) {
            die('Couldn\'t delete ' . $this->table);
        }

        // check count rows if succeded...
        echo $this->table . " deleted";

    }

    public function update(int $id)
    {
        $json = file_get_contents("php://input");
        $post_data = json_decode($json);

        $fields = '';

        foreach($post_data as $key => $value) {
            $fields .=  "{$key} = :{$key}, ";
        }

        $fields = rtrim($fields, ', ');

        $sth = $this->db->prepare("UPDATE {$this->table} SET {$fields} WHERE id = :id");

        $data = [':id' => $id];

        foreach($post_data as $key => $value) {
            $curr_key = ":{$key}";
            $data[$curr_key] = $value;

            if ($key === 'password') {
                $data[$curr_key] = password_hash($value, PASSWORD_DEFAULT);
            }
        }

        if (! $sth->execute($data)) {
            die('Couldn\'t update ' . $this->table);
        }

        echo $this->table . ' updated';
    }

}

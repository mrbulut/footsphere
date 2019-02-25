<?php

class Db
{
    private $host = 'localhost';
    private $schema = 'test';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';
    private $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->pdo = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->schema . ';charset=' .
            $this->charset,
            $this->user,
            $this->pass);
    }

    public function fetch($sql)
    {
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll($sql)
    {
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}

/*


$host = 'localhost';
        $schema = 'test';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';

        $pdo =
        $sql = $pdo->prepare('SELECT * FROM users');
        $sql->execute();

        $result =




 */
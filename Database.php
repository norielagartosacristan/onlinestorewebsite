<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'your_database_name';

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        try {
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

?>

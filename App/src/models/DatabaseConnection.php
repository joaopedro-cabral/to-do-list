<?php

namespace App\Models;

class DatabaseConnection
{
    private $host = 'localhost';
    private $port = '3307';
    private $databaseName = 'xneo';
    private $username = 'root';
    private $password = '';

    public $conn;

    public function getConnection() 
    {
        $this->conn = null;
        try
        {
            $this->conn = new \PDO('mysql:host=' . $this->host . 
                                   ';port=' . $this->port . 
                                   ';dbname=' . $this->databaseName, 
                                   $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $exception){
            echo '<h1>Something went wrong: ' . $exception->getMessage().'</h1>';
        }
        
        return $this->conn;
    }
}

?>
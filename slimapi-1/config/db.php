<?php

class DB {
    private $host = 'localhost';
    private $user = 'root';
    // private $pass = 'root';
    private $dbname = 'slimapi';

    public function connect() {
        // connect to the database
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        // Connection 
        $conn = new PDO($conn_str, $this->user);
        // 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn; 
    }
}

?>
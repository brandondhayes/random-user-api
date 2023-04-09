<?php

// connect to DB
// pick a random user from database
// return info about user as JSON

class Database {
    private $host = '127.0.0.1:3306';
    private $username = 'USERNAME';
    private $password = 'PASSWORD';
    private $database = 'DATABASE';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function close() {
        $this->conn->close();
    }
}

header('Content-Type: application/json; charset=utf-8');

$db = new Database();
$result = $db->query("SELECT * FROM `random_users` ORDER BY RAND() LIMIT 1");
echo json_encode($result);
$db->close();


?>
<?php
require_once 'config.php';

class Database {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            die(json_encode([
                'status' => 'error',
                'message' => 'Database connection failed: ' . $this->connection->connect_error
            ]));
        }
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close() {
        $this->connection->close();
    }
}
?>
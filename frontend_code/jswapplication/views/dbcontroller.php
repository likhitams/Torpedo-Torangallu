<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "torangallu"; // fixed name
    private $conn;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // throw on errors
        $this->conn = $this->connectDB();
    }

    private function connectDB() {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        mysqli_set_charset($conn, 'utf8mb4');
        return $conn;
    }

    public function runQuery($query) {
        $result = mysqli_query($this->conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows; // empty array if no rows
    }

    public function numRows($query) {
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
    }

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}

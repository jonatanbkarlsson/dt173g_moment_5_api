<?php
/**
 *  ———————————————————————————————————————————————————————————————————————————————
 * | id (int(10), AI, PRIMARY KEY) | code (varchar(25) INDEX) | name (varchar(50)) |
 * | progression (varchar(5)) | syllabus (varchar(50))                             |
 *  ———————————————————————————————————————————————————————————————————————————————
 */

class Database {
    // Databasuppgifter.
    private $host = "HOST";
    private $username = "USERNAME";
    private $password = "PASSWORD";
    private $database = "DATABASE";
    private $conn;

    // Anslut till databas.
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $error) {
            echo "Connection Error " . $error->getMessage();
        }

        return $this->conn;
    }

    // Stäng anslutningen.
    public function close() {
        $this->conn = null;
    }
}
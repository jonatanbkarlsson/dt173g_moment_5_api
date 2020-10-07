<?php
class Course {
    private $conn;

    // Tabellkolumner.
    public $id;
    public $code;
    public $name;
    public $progression;
    public $syllabus;

    // Sätt upp databasanslutning.
    public function __construct($db) {
        $this->conn = $db;
    }

    // Hämta alla kurser.
    public function read() {
        // SQL-fråga.
        $query = "SELECT * FROM courses";

        // Sätt upp anslutning med fråga.
        $statement = $this->conn->prepare($query);

        // Skicka fråga.
        $statement->execute();

        // Räkna antal rader skickade.
        $count = $statement->rowCount();

        $result = [];

        if ($count > 0) {
            // Loopa alla rader och sätt i array.
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }

        } else {
            http_response_code(404);
            $result = ['Message' => 'Nothing found.', 'HTTP Response Code' => http_response_code()];
        }

        return $result;
    }

    // Hämta specifik kurs.
    public function readOne() {
        // SQL-fråga med specifik rad (id).
        $query = "SELECT * FROM courses WHERE id=:id";
        $statement = $this->conn->prepare($query);

        // Länka parametern id till den satta.
        $statement->bindParam(':id', $this->id);
        $statement->execute();
        $count = $statement->rowCount();

        if ($count > 0) {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
           
        } else {
            http_response_code(404);
            $result = ['Message' => 'Nothing found.', 'HTTP Response Code' => http_response_code()];
        }

        return $result;
    }

    // Skapa ny kurs.
    public function create() {
        $query = "INSERT INTO courses SET code=:code, name=:name, progression=:progression, syllabus=:syllabus";
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':code', $this->code);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':progression', $this->progression);
        $statement->bindParam(':syllabus', $this->syllabus);

        return $statement->execute();
    }

    // Uppdatera befintlig kurs.
    public function update() {
        $query = "UPDATE courses SET code=:code, name=:name, progression=:progression, syllabus=:syllabus WHERE id=:id";
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':code', $this->code);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':progression', $this->progression);
        $statement->bindParam(':syllabus', $this->syllabus);

        return $statement->execute();
    }

    // Radera kurs.
    public function delete() {
        $query = "DELETE FROM courses WHERE id=:id";
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':id', $this->id);

        return $statement->execute();
    }
}
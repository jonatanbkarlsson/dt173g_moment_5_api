<?php
/**
 * Author: Jonatan Bergström Karlsson.
 * Author email: joka1713@student.miun.se.
 * Date: 2020-09-28.
 * 
 * POST            Creates a new resource.
 * GET             Retrieves a resource.
 * PUT             Updates an existing resource.
 * DELETE          Deletes a resource.
 */

require 'config/Database.php';
require 'classes/Course.php';

// Konvertera header till JSON & tillåter extern hämtning av data.
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, DELETE, POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, x-Requested-With');

// Hämtad metod.
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'));

// Anslut till databasen.
$database = new Database();
$db = $database->connect();

// Skapa ny modell.
$course = new Course($db);

// filtrera metod.
switch ($method) {
    case 'GET':
        // Läs specifik rad om id är medskickat.
        if (isset($_GET['id'])) {
            $course->id = $_GET['id'];
            $result = $course->readOne();

        } else {
            $result = $course->read();
        }
        break;

    case 'POST':
        // Skapa ny klass.
        $course->code = htmlspecialchars(strip_tags($input->code));
        $course->name = htmlspecialchars(strip_tags($input->name));
        $course->progression = htmlspecialchars(strip_tags($input->progression));
        $course->syllabus = htmlspecialchars(strip_tags($input->syllabus));

        if ($course->create()) {
            http_response_code(201);
            $result = ['Message' => 'Course created.'];

        } else {
            http_response_code(503);
            $result = ['Message' => 'Course was not created.', 'HTTP Response Code' => http_response_code()];
        }
        break;

    case 'PUT':
        // Kontrollera att id är medskickat.
        if (isset($_GET['id'])) {
            // Skapa ny klass.
            $course->id = $_GET['id'];
            $course->code = htmlspecialchars(strip_tags($input->code));
            $course->name = htmlspecialchars(strip_tags($input->name));
            $course->progression = htmlspecialchars(strip_tags($input->progression));
            $course->syllabus = htmlspecialchars(strip_tags($input->syllabus));

            if ($course->update()) {
                $result = ['Message' => 'Course updated.'];
    
            } else {
                http_response_code(503);
                $result = ['Message' => 'Cours was not updated.', 'HTTP Response Code' => http_response_code()];
            }

        } else {
            // Skicka felmeddelande om id inte är medskickat.
            http_response_code(510);
            $result = ['Message' => 'No id set.', 'HTTP Response Code' => http_response_code()];
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            // Sätt id för den kurs som ska raderas.
            $course->id = $_GET['id'];

            if ($course->delete()) {
                $result = ['Message' => 'Course was deleted.'];
    
            } else {
                http_response_code(503);
                $result = ['Message' => 'Cours was not deleted.', 'HTTP Response Code' => http_response_code()];
            }

        } else {
            // Skicka felmeddelande om id inte är medskickat.
            http_response_code(510);
            $result = ['Message' => 'No id set.', 'HTTP Response Code' => http_response_code()];
        }
        break;
    
    default:
        // Informera om vald metod inte är skapad.
        http_response_code(405);
        $result = ['Message' => 'Method not allowed.', 'HTTP Response Code' => http_response_code()];
        break;
}

// Skicka svar i JSON-format.
echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

// Stäng databasanslutning.
$db = $database->close();
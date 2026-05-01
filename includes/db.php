<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dbstudents";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getStudents() {
    $file = __DIR__ . '/../data/students.json';
    if (!file_exists($file)) {
        return [];
    }
    $data = file_get_contents($file);
    return json_decode($data, true) ?: [];
}

function saveStudents($students) {
    $file = __DIR__ . '/../data/students.json';
    file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT));
}
?>

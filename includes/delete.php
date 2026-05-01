<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    $students = getStudents();
    $initial_count = count($students);

    $students = array_filter($students, function($student) use ($id) {
        return $student['id'] != $id;
    });

    $students = array_values($students);

    if (count($students) < $initial_count) {
        saveStudents($students);
        header("Location: ../index.php?status=deleted");
        exit();
    } else {
        echo "Error: Student not found.";
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>

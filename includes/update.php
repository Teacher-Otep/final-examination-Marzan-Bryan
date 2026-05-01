<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $middlename = trim($_POST['middlename']);
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);

    $students = getStudents();
    $updated = false;

    foreach ($students as &$student) {
        if ($student['id'] == $id) {
            $student['name'] = $name;
            $student['surname'] = $surname;
            $student['middlename'] = $middlename;
            $student['address'] = $address;
            $student['contact_number'] = $contact_number;
            $student['email'] = $email;
            $student['gender'] = $gender;
            $student['course'] = $course;
            $student['year_level'] = $year_level;
            $updated = true;
            break;
        }
    }

    if ($updated) {
        saveStudents($students);
        header("Location: ../index.php?status=updated");
        exit();
    } else {
        echo "Error: Student not found.";
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>

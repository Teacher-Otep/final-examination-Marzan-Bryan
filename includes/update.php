<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $middlename = $_POST['middlename'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact'];

    $students = getStudents();
    $updated = false;


    foreach ($students as &$student) {
        if ($student['id'] == $id) {
            $student['name'] = $name;
            $student['surname'] = $surname;
            $student['middlename'] = $middlename;
            $student['address'] = $address;
            $student['contact_number'] = $contact_number;
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

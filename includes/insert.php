<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $middlename = $_POST['middlename'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact'];

    $students = getStudents();
    
    $max_id = 0;
    foreach ($students as $student) {
        if ($student['id'] > $max_id) {
            $max_id = $student['id'];
        }
    }
    $new_id = $max_id + 1;

    $new_student = [
        'id' => $new_id,
        'name' => $name,
        'surname' => $surname,
        'middlename' => $middlename,
        'address' => $address,
        'contact_number' => $contact_number
    ];

    $students[] = $new_student;
    saveStudents($students);

    header("Location: ../index.php?status=success");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>

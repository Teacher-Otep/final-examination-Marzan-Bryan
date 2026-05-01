<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $middlename = trim($_POST['middlename']);

    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);
    $enrollment_date = date('Y-m-d');

    $students = getStudents();
    
    // dytuy jy auto increment ID
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
        'contact_number' => $contact_number,
        'email' => $email,
        'gender' => $gender,
        'course' => $course,
        'year_level' => $year_level,
        'enrollment_date' => $enrollment_date
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

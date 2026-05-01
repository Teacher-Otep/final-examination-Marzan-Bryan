<?php
include 'db.php';

$students = getStudents();

// header for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=students_export_' . date('Y-m-d_His') . '.csv');

// pang ipen ng output stream
$output = fopen('php://output', 'w');

// Write CSV header row
fputcsv($output, ['ID', 'Surname', 'Name', 'Middle Name', 'Email', 'Gender', 'Course', 'Year Level', 'Address', 'Contact Number', 'Enrollment Date']);

// Write student data
foreach ($students as $student) {
    fputcsv($output, [
        $student['id'] ?? '',
        $student['surname'] ?? '',
        $student['name'] ?? '',
        $student['middlename'] ?? '',
        $student['email'] ?? '',
        $student['gender'] ?? '',
        $student['course'] ?? '',
        $student['year_level'] ?? '',
        $student['address'] ?? '',
        $student['contact_number'] ?? '',
        $student['enrollment_date'] ?? ''
    ]);
}

fclose($output);
exit();
?>

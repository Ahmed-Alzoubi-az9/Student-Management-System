<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Student.php';

$database = new Database();
$db = $database->connect();
$studentModel = new Student($db);
$students = $studentModel->getAllStudents();

$timestamp = date('Y-m-d_H-i-s');
$filename = "students_export_" . $timestamp . ".csv";
$filepath = __DIR__ . "/../exports/" . $filename;

if (!is_dir(__DIR__ . '/../exports')) {
    mkdir(__DIR__ . '/../exports', 0777, true);
}

$file = fopen($filepath, 'w');
fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 

$headers = [
    'ID',
    'Student ID',
    'Full Name',
    'Email',
    'Class',
    'Grade',
    'Date of Birth',
    'Address',
    'Nationality',
    'Parent Number',
    'Health Info'
];
fputcsv($file, $headers);

foreach ($students as $student) {
    $row = [
        $student['id'],
        $student['student_id'],
        $student['fullname'],
        $student['email'],
        $student['class'],
        $student['grade'],
        $student['date_of_birth'] ?? '',
        $student['address'] ?? '',
        $student['nationality'] ?? '',
        $student['parent_number'] ?? '',
        $student['health_info'] ?? ''
    ];
    fputcsv($file, $row);
}

fclose($file);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Pragma: no-cache');
header('Expires: 0');
readfile($filepath);

exit;

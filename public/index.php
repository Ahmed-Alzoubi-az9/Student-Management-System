<?php
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Student.php';
require_once __DIR__ . '/../app/controllers/StudentController.php';

$db = new Database();
$conn = $db->connect();

$studentModel = new Student($conn);
$controller = new StudentController($studentModel);

$students = $controller->getStudents();
if (!is_array($students)) {
    $students = [];
}


include __DIR__ . '/../app/views/students/index.php';

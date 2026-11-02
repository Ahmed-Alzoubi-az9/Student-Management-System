<?php
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Teacher.php';
require_once __DIR__ . '/../app/controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();

$teacherModel = new Teacher($conn);
$controller = new TeacherController($teacherModel);

$teachers = $controller->getTeachers();
if (!is_array($teachers)) {
    $teachers = [];
}

$navActive = 'teachers';
$assetBase = 'assets';

include __DIR__ . '/../app/views/teachers/index.php';

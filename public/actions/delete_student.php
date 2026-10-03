<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Student.php';
require_once __DIR__ . '/../../app/controllers/StudentController.php';

$db = new Database();
$conn = $db->connect();
$model = new Student($conn);
$controller = new StudentController($model);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $result = $controller->deleteStudent($id);
    echo ($result === "The student has been deleted successfully.") ? 'success' : 'error';
} else {
    echo 'invalid_request';
}
exit;

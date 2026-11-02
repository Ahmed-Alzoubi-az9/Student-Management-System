<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Teacher.php';
require_once __DIR__ . '/../../app/controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();
$controller = new TeacherController(new Teacher($conn));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $result = $controller->deleteTeacher($id);
    echo ($result === "The teacher has been deleted successfully.") ? 'success' : 'error';
} else {
    echo 'invalid_request';
}
exit;

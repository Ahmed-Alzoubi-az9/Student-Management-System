<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Subject.php';
require_once __DIR__ . '/../../app/controllers/SubjectController.php';

$db = new Database();
$conn = $db->connect();
$controller = new SubjectController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $result = $controller->deleteSubject($id);
    echo ($result === "The subject has been deleted successfully.") ? 'success' : 'error';
} else {
    echo 'invalid_request';
}
exit;

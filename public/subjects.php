<?php
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Subject.php';
require_once __DIR__ . '/../app/controllers/SubjectController.php';

$db = new Database();
$conn = $db->connect();

$subjectModel = new Subject($conn);
$controller = new SubjectController($subjectModel);

$subjects = $controller->getSubjects();
if (!is_array($subjects)) {
    $subjects = [];
}

$navActive = 'subjects';
$assetBase = 'assets';

include __DIR__ . '/../app/views/subjects/index.php';

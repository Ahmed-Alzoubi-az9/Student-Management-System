<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Subject.php';
require_once __DIR__ . '/../../app/controllers/SubjectController.php';

$db = new Database();
$conn = $db->connect();
$controller = new SubjectController($conn);

$query = isset($_POST['query']) ? trim($_POST['query']) : '';
$filter = isset($_POST['filter']) ? trim($_POST['filter']) : 'all';
$subjects = $controller->searchSubject($query, $filter);

if (!empty($subjects) && is_array($subjects)) {
    foreach ($subjects as $subject) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($subject['id']) . '</td>';
        echo '<td><span class="app-badge badge-subject">' . htmlspecialchars($subject['code']) . '</span></td>';
        echo '<td><strong>' . htmlspecialchars($subject['name']) . '</strong></td>';
        echo '<td>' . htmlspecialchars($subject['description'] ?? '') . '</td>';
        echo '<td>';
        echo '<a href="../app/views/subjects/edit.php?id=' . $subject['id'] . '" class="btn btn-edit btn-sm">Edit</a>';
        echo '<a href="#" class="btn btn-delete btn-sm" data-id="' . $subject['id'] . '">Delete</a>';
        echo '<a href="../app/views/subjects/show.php?id=' . $subject['id'] . '" class="btn btn-view btn-sm">View</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" class="text-center">No subjects found</td></tr>';
}

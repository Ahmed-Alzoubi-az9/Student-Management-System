<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Teacher.php';
require_once __DIR__ . '/../../app/controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();
$controller = new TeacherController(new Teacher($conn));

$query = isset($_POST['query']) ? trim($_POST['query']) : '';
$filter = isset($_POST['filter']) ? trim($_POST['filter']) : 'all';
$teachers = $controller->searchTeacher($query, $filter);

if (!empty($teachers) && is_array($teachers)) {
    foreach ($teachers as $teacher) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($teacher['id']) . '</td>';
        echo '<td><strong>' . htmlspecialchars($teacher['fullname']) . '</strong></td>';
        echo '<td>' . htmlspecialchars($teacher['email']) . '</td>';
        echo '<td>' . htmlspecialchars($teacher['phone'] ?? '') . '</td>';
        echo '<td>';
        if (!empty($teacher['subject_code'])) {
            echo '<span class="app-badge badge-subject">' . htmlspecialchars($teacher['subject_code']) . '</span>';
            echo '<span class="text-muted-sm">' . htmlspecialchars($teacher['subject_name']) . '</span>';
        } else {
            echo '<span class="text-muted-sm">—</span>';
        }
        echo '</td>';
        echo '<td>';
        echo '<a href="../app/views/teachers/edit.php?id=' . $teacher['id'] . '" class="btn btn-edit btn-sm">Edit</a>';
        echo '<a href="#" class="btn btn-delete btn-sm" data-id="' . $teacher['id'] . '">Delete</a>';
        echo '<a href="../app/views/teachers/show.php?id=' . $teacher['id'] . '" class="btn btn-view btn-sm">View</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center">No teachers found</td></tr>';
}

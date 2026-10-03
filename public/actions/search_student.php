<?php
require_once __DIR__ . '/../../app/models/Database.php';
require_once __DIR__ . '/../../app/models/Student.php';
require_once __DIR__ . '/../../app/controllers/StudentController.php';

$db = new Database();
$conn = $db->connect();
$controller = new StudentController(new Student($conn));

$query = isset($_POST['query']) ? trim($_POST['query']) : '';
$filter = isset($_POST['filter']) ? trim($_POST['filter']) : 'all';
$students = $controller->searchStudent($query, $filter);

if (!empty($students) && is_array($students)) {
    foreach ($students as $student) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($student['id']) . '</td>';
        echo '<td>' . htmlspecialchars($student['fullname']) . '</td>';
        echo '<td>' . htmlspecialchars($student['student_id']) . '</td>';
        echo '<td>' . htmlspecialchars($student['email']) . '</td>';
        echo '<td>' . htmlspecialchars($student['nationality'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($student['class']) . '</td>';
        echo '<td>' . htmlspecialchars($student['grade']) . '</td>';
        echo '<td>';
        echo '<a href="../app/views/students/edit.php?id=' . $student['id'] . '" class="btn-edit">Edit</a>';
        echo '<a href="#" class="btn-delete" data-id="' . $student['id'] . '">Delete</a>';
        echo '<a href="../app/views/students/show.php?id=' . $student['id'] . '" class="btn-view">View</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="12" style="text-align:center;">No students found</td></tr>';
}

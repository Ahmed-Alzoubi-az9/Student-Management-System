<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Teacher.php';
require_once __DIR__ . '/../../controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();
$controller = new TeacherController(new Teacher($conn));

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$teacher = $controller->getTeacher($id);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../../../public/assets/js/site.js"></script>
    <script src="../../../public/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php $assetBase = '../../../public/assets'; include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container my-2 page-panel">
        <h1>Teacher Details</h1>

        <?php if (is_array($teacher)): ?>
            <div class="table-responsive">
                <table class="table table-bordered uniform-table">
                    <tbody>
                        <?php foreach ($teacher as $field => $value): ?>
                            <tr>
                                <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $field))) ?></th>
                                <td><?= nl2br(htmlspecialchars($value === null ? '' : (string) $value)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning"><?= htmlspecialchars($teacher) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-center mt-2">
            <a href="../../../public/teachers.php" class="btn btn-secondary w-25">Back</a>
        </div>
    </div>
</body>

</html>

<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Student.php';
require_once __DIR__ . '/../../controllers/StudentController.php';

$db = new Database();
$conn = $db->connect();
$model = new Student($conn);
$controller = new StudentController($model);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student = $controller->getStudent($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../../../public/assets/js/script.js"></script>
</head>

<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Student Details</h1>

        <?php if (is_array($student)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <?php foreach ($student as $field => $value): ?>
                            <tr>
                                <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $field))) ?></th>
                                <td><?= nl2br(htmlspecialchars($value)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning"><?= htmlspecialchars($student) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-center mt-2">
            <a href="../../../public/index.php" class="btn btn-secondary w-25">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
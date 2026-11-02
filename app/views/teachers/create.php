<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Subject.php';
require_once __DIR__ . '/../../models/Teacher.php';
require_once __DIR__ . '/../../controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();

$teacherController = new TeacherController(new Teacher($conn));
$subjects = (new Subject($conn))->getAllSubjects();

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $teacherController->addTeacher($_POST);
    if ($result === "The teacher has been added successfully.") {
        $success = "Teacher added successfully!";
    } else {
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../../../public/assets/js/site.js"></script>
    <script src="../../../public/assets/js/script.js"></script>
</head>

<body>
    <?php $assetBase = '../../../public/assets'; include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container my-2 page-panel">
        <h1>Add New Teacher</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible mx-auto" role="alert" style="max-width: 500px; text-align: center;">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($success): ?>
            <div class="alert alert-success alert-dismissible mx-auto" role="alert" style="max-width: 500px; text-align: center;">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="fullname" class="form-control" placeholder="e.g. Ali Nasser" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="teacher@school.edu" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="+962 79 ...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Subject</label>
                <select name="subject_id" class="form-select">
                    <option value="">— No subject —</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= (int) $subject['id'] ?>"><?= htmlspecialchars($subject['code'] . ' — ' . $subject['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex flex-column align-items-center gap-2 mt-3">
                <button type="submit" class="btn btn-add w-25">Add Teacher</button>
                <a href="../../../public/teachers.php" class="btn btn-secondary w-25">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

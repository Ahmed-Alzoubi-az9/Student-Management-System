<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Subject.php';
require_once __DIR__ . '/../../controllers/SubjectController.php';

$db = new Database();
$conn = $db->connect();
$controller = new SubjectController(new Subject($conn));

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $controller->addSubject($_POST);
    if ($result === "The subject has been added successfully.") {
        $success = "Subject added successfully!";
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
    <title>Add Subject</title>
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
        <h1>Add New Subject</h1>
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
                <label class="form-label fw-bold">Code</label>
                <input type="text" name="code" class="form-control" placeholder="e.g. CS-104" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Advanced Web Development" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="What is this subject about?"></textarea>
            </div>

            <div class="d-flex flex-column align-items-center gap-2 mt-3">
                <button type="submit" class="btn btn-add w-25">Add Subject</button>
                <a href="../../../public/subjects.php" class="btn btn-secondary w-25">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

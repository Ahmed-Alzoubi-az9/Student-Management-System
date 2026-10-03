<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Student.php';
require_once __DIR__ . '/../../controllers/StudentController.php';

$db = new Database();
$conn = $db->connect();
$model = new Student($conn);
$controller = new StudentController($model);

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $controller->addStudent($_POST);
    if ($result === "The student has been added successfully.") {
        $success = "Student added successfully!";
    } else {
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../../../public/assets/js/script.js"></script>
</head>

<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Add New Student</h1>
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



        <form action="" method="post" class="mx-auto">
            <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>
            <input type="text" name="student_id" class="form-control mb-3" placeholder="Student ID" required>
            <input type="date" name="date_of_birth" class="form-control mb-3">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="text" name="nationality" class="form-control mb-3" placeholder="Nationality">
            <input type="text" name="class" class="form-control mb-3" placeholder="Class" required>
            <input type="text" name="grade" class="form-control mb-3" placeholder="Grade" required>
            <input type="text" name="address" class="form-control mb-3" placeholder="Address">
            <input type="text" name="parent_number" class="form-control mb-3" placeholder="Parent Phone Number">
            <textarea name="health_info" class="form-control mb-3" rows="3" placeholder="Health Info"></textarea>
            <div class="d-flex flex-column align-items-center gap-2 mt-3">
                <button type="submit" class="btn btn-success w-25">Add Student</button>
                <a href="../../../public/index.php" class="btn btn-secondary w-25">Back</a>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
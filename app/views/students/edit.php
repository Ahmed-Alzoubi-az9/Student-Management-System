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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $controller->updateStudent($id, $_POST);
    if ($result === "The student has been updated successfully.") {
        header('Location: ../../../public/index.php?msg=updated');
        exit;
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
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/mid_level/Students_Manager_System/public/assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../public/assets/js/script.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="text-center mb-4">Edit Student</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (is_array($student)): ?>
    <form action="" method="post" class="mx-auto" style="max-width: 500px;">
      <div class="mb-3">
        <label for="fullname" class="form-label fw-bold">Full Name</label>
        <input type="text" name="fullname" id="fullname" class="form-control" value="<?= htmlspecialchars($student['fullname']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="student_id" class="form-label fw-bold">Student ID</label>
        <input type="text" name="student_id" id="student_id" class="form-control" value="<?= htmlspecialchars($student['student_id']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="date_of_birth" class="form-label fw-bold">Date of Birth</label>
        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?= htmlspecialchars($student['date_of_birth'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="nationality" class="form-label fw-bold">Nationality</label>
        <input type="text" name="nationality" id="nationality" class="form-control" value="<?= htmlspecialchars($student['nationality'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="class" class="form-label fw-bold">Class</label>
        <input type="text" name="class" id="class" class="form-control" value="<?= htmlspecialchars($student['class']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="grade" class="form-label fw-bold">Grade</label>
        <input type="text" name="grade" id="grade" class="form-control" value="<?= htmlspecialchars($student['grade']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="address" class="form-label fw-bold">Address</label>
        <input type="text" name="address" id="address" class="form-control" value="<?= htmlspecialchars($student['address'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="parent_number" class="form-label fw-bold">Parent Number</label>
        <input type="text" name="parent_number" id="parent_number" class="form-control" value="<?= htmlspecialchars($student['parent_number'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="health_info" class="form-label fw-bold">Health Information</label>
        <textarea name="health_info" id="health_info" class="form-control" rows="3"><?= htmlspecialchars($student['health_info'] ?? '') ?></textarea>
      </div>

      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success">Update Student</button>
        <a href="../../../public/index.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  <?php else: ?>
    <div class="alert alert-warning"><?= htmlspecialchars($student) ?></div>
  <?php endif; ?>
</div>

</body>
</html>

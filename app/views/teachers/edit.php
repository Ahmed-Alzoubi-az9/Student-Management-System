<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Subject.php';
require_once __DIR__ . '/../../models/Teacher.php';
require_once __DIR__ . '/../../controllers/TeacherController.php';

$db = new Database();
$conn = $db->connect();

$teacherController = new TeacherController(new Teacher($conn));
$subjects = (new Subject($conn))->getAllSubjects();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$teacher = $teacherController->getTeacher($id);
$teacher = is_array($teacher) ? $teacher : null;

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $teacherController->updateTeacher($id, $_POST);
    if ($result === "The teacher has been updated successfully.") {
        header('Location: ../../../public/teachers.php?msg=updated');
        exit;
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
  <title>Edit Teacher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../../public/assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="../../../public/assets/js/site.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../public/assets/js/script.js"></script>
</head>
<body>

<?php $assetBase = '../../../public/assets'; include __DIR__ . '/../partials/navbar.php'; ?>

<div class="container my-2 page-panel">
  <h1>Edit Teacher</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($teacher): ?>
    <form action="" method="post" class="mx-auto" style="max-width: 500px;">
      <div class="mb-3">
        <label for="fullname" class="form-label fw-bold">Full Name</label>
        <input type="text" name="fullname" id="fullname" class="form-control" value="<?= htmlspecialchars($teacher['fullname']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($teacher['email']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label fw-bold">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($teacher['phone'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="subject_id" class="form-label fw-bold">Subject</label>
        <select name="subject_id" id="subject_id" class="form-select">
          <option value="">— No subject —</option>
          <?php foreach ($subjects as $subject): ?>
            <option value="<?= (int) $subject['id'] ?>" <?= ((string) ($teacher['subject_id'] ?? '')) !== '' && (int) $teacher['subject_id'] === (int) $subject['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($subject['code'] . ' — ' . $subject['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-add">Update Teacher</button>
        <a href="../../../public/teachers.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  <?php else: ?>
    <div class="alert alert-warning">This teacher not found.</div>
  <?php endif; ?>
</div>

</body>
</html>

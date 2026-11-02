<?php
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Subject.php';
require_once __DIR__ . '/../../controllers/SubjectController.php';

$db = new Database();
$conn = $db->connect();
$controller = new SubjectController(new Subject($conn));

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$subject = $controller->getSubject($id);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $controller->updateSubject($id, $_POST);
    if ($result === "The subject has been updated successfully.") {
        header('Location: ../../../public/subjects.php?msg=updated');
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
  <title>Edit Subject</title>
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
  <h1>Edit Subject</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (is_array($subject)): ?>
    <form action="" method="post" class="mx-auto" style="max-width: 500px;">
      <div class="mb-3">
        <label for="code" class="form-label fw-bold">Code</label>
        <input type="text" name="code" id="code" class="form-control" value="<?= htmlspecialchars($subject['code']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label fw-bold">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($subject['name']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($subject['description'] ?? '') ?></textarea>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-add">Update Subject</button>
        <a href="../../../public/subjects.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  <?php else: ?>
    <div class="alert alert-warning"><?= htmlspecialchars($subject) ?></div>
  <?php endif; ?>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="assets/js/site.js"></script>
    <script>
        window.AppConfig = {
            deleteUrl: 'actions/delete_subject.php',
            searchUrl: 'actions/search_subject.php'
        };
    </script>
    <script src="assets/js/script.js"></script>
</head>

<body>
    <?php $assetBase = 'assets'; include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container my-2">
        <h1>Subject Manager</h1>

        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <a href="../app/views/subjects/create.php" class="btn btn-add">Add New Subject</a>
            </div>

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search subjects...">
                <select id="filterSelect" class="form-select">
                    <option value="all">All</option>
                    <option value="code">Code</option>
                    <option value="name">Name</option>
                    <option value="description">Description</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle uniform-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $subjects = isset($subjects) && is_array($subjects) ? $subjects : []; ?>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?= htmlspecialchars($subject['id']) ?></td>
                                <td><span class="app-badge badge-subject"><?= htmlspecialchars($subject['code']) ?></span></td>
                                <td><strong><?= htmlspecialchars($subject['name']) ?></strong></td>
                                <td><?= htmlspecialchars($subject['description'] ?? '') ?></td>
                                <td>
                                    <a href="../app/views/subjects/edit.php?id=<?= $subject['id'] ?>" class="btn btn-edit btn-sm">Edit</a>
                                    <a href="#" class="btn btn-delete btn-sm" data-id="<?= $subject['id'] ?>">Delete</a>
                                    <a href="../app/views/subjects/show.php?id=<?= $subject['id'] ?>" class="btn btn-view btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">There are currently no subjects.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h3>Delete this subject?</h3>
                <p class="text-muted-sm mt-1 mb-0">Teachers assigned to it will become unassigned.</p>
                <div class="modal-buttons">
                    <button id="confirmDelete" class="btn btn-confirm">Yes, Delete</button>
                    <button id="cancelDelete" class="btn btn-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="app-footer">© <?= date('Y') ?> Student Manager System — <a href="index.php">Students</a> · <a href="teachers.php">Teachers</a> · <a href="subjects.php">Subjects</a></div>
</body>

</html>

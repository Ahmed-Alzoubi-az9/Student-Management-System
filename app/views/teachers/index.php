<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="assets/js/site.js"></script>
    <script>
        window.AppConfig = {
            deleteUrl: 'actions/delete_teacher.php',
            searchUrl: 'actions/search_teacher.php'
        };
    </script>
    <script src="assets/js/script.js"></script>
</head>

<body>
    <?php $assetBase = 'assets'; include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container my-2">
        <h1>Teacher Manager</h1>

        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <a href="../app/views/teachers/create.php" class="btn btn-add">Add New Teacher</a>
            </div>

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search teachers...">
                <select id="filterSelect" class="form-select">
                    <option value="all">All</option>
                    <option value="fullname">Full Name</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle uniform-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $teachers = isset($teachers) && is_array($teachers) ? $teachers : []; ?>
                    <?php if (!empty($teachers)): ?>
                        <?php foreach ($teachers as $teacher): ?>
                            <tr>
                                <td><?= htmlspecialchars($teacher['id']) ?></td>
                                <td><strong><?= htmlspecialchars($teacher['fullname']) ?></strong></td>
                                <td>
                                    <?= htmlspecialchars($teacher['email']) ?>
                                </td>
                                <td><?= htmlspecialchars($teacher['phone'] ?? '') ?></td>
                                <td>
                                    <?php if (!empty($teacher['subject_code'])): ?>
                                        <span class="app-badge badge-subject"><?= htmlspecialchars($teacher['subject_code']) ?></span>
                                        <span class="text-muted-sm"><?= htmlspecialchars($teacher['subject_name']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted-sm">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="../app/views/teachers/edit.php?id=<?= $teacher['id'] ?>" class="btn btn-edit btn-sm">Edit</a>
                                    <a href="#" class="btn btn-delete btn-sm" data-id="<?= $teacher['id'] ?>">Delete</a>
                                    <a href="../app/views/teachers/show.php?id=<?= $teacher['id'] ?>" class="btn btn-view btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">There are currently no teachers.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h3>Delete this teacher?</h3>
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

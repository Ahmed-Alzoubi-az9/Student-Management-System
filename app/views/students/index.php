<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="assets/js/site.js"></script>
    <script src="assets/js/script.js"></script>
</head>

<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container my-2">
        <h1>Student Manager</h1>

        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <a href="../app/views/students/create.php" class="btn btn-add">Add New Student</a>
                <a href="actions/export_students.php" class="btn btn-export">Export to CSV</a>
            </div>

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search students...">
                <select id="filterSelect" class="form-select">
                    <option value="all">All</option>
                    <option value="fullname">Full Name</option>
                    <option value="student_id">Student ID</option>
                    <option value="email">Email</option>
                    <option value="nationality">Nationality</option>
                    <option value="class">Class</option>
                    <option value="grade">Grade</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle uniform-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Nationality</th>
                        <th>Class</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $students = isset($students) && is_array($students) ? $students : []; ?>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['id']) ?></td>
                                <td><strong><?= htmlspecialchars($student['fullname']) ?></strong></td>
                                <td><span class="app-badge badge-student"><?= htmlspecialchars($student['student_id']) ?></span></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= htmlspecialchars($student['nationality'] ?? '') ?></td>
                                <td><span class="app-badge badge-class"><?= htmlspecialchars($student['class']) ?></span></td>
                                <td><span class="app-badge badge-grade"><?= htmlspecialchars($student['grade']) ?></span></td>
                                <td>
                                    <a href="../app/views/students/edit.php?id=<?= $student['id'] ?>" class="btn btn-edit btn-sm">Edit</a>
                                    <a href="#" class="btn btn-delete btn-sm" data-id="<?= $student['id'] ?>">Delete</a>
                                    <a href="../app/views/students/show.php?id=<?= $student['id'] ?>" class="btn btn-view btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">There are currently no students.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h3>Delete this student?</h3>
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

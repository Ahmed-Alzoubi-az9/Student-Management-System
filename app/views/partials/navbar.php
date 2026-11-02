<?php
/**
 * Shared top navbar (included by every page).
 * Expects optional variables (all optional):
 *   $navActive  — 'students' | 'teachers' | 'subjects' | '' (defaults to '')
 *   $assetBase  — relative prefix to public/assets, e.g. 'assets' from public/*.php pages
 *                 or '../../../public/assets' from app/views/** pages (required)
 * Pages live both in public/*.php (index, teachers, subjects) and in app/views/**
 * so nav links are resolved relative to the served page (public folder).
 */
$navActive = isset($navActive) ? $navActive : '';
$assetBase = isset($assetBase) ? $assetBase : 'assets';
?>
<nav class="app-navbar navbar navbar-expand-lg">
    <div class="container bg-transparent shadow-none py-1">
        <a class="navbar-brand app-brand fw-bold" href="index.php">Student Manager System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="appNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link app-nav-link <?= $navActive === 'students' ? 'active' : '' ?>" href="index.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link app-nav-link <?= $navActive === 'teachers' ? 'active' : '' ?>" href="teachers.php">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link app-nav-link <?= $navActive === 'subjects' ? 'active' : '' ?>" href="subjects.php">Subjects</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <button type="button" class="btn btn-sm app-theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                        <i class="bi bi-moon-stars" data-theme-icon="dark"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

# Student Management System

A simple PHP + MySQL (PDO) CRUD app for managing students — built for XAMPP. Search/filter with AJAX, delete with modal + AJAX, export to CSV.

## Features

- List students (`public/index.php`)
- Add student (`app/views/students/create.php`)
- View student details (`app/views/students/show.php`)
- Edit student (`app/views/students/edit.php`)
- Delete with confirmation modal + AJAX (`public/actions/delete_student.php`)
- Live search + filter by field via AJAX (`public/actions/search_student.php`)
- Export to CSV with UTF-8 BOM (`public/actions/export_students.php`)
- Server-side validation (required fields, email, numeric grade)
- Empty-state handling — `getStudents()` always returns `array`

## Tech stack

- PHP 8 + PDO MySQL
- MySQL / MariaDB (XAMPP)
- Bootstrap 5.3, jQuery 3.7, vanilla CSS/JS
- No framework, no Composer

## Project structure

```
Student-Management-System/
├── app/
│   ├── controllers/StudentController.php
│   ├── models/
│   │   ├── Database.php      # PDO connection (localhost / student_manager / root / "")
│   │   └── Student.php       # CRUD + search queries
│   └── views/students/
│       ├── index.php         # table (expects $students array)
│       ├── create.php
│       ├── edit.php
│       └── show.php
├── public/
│   ├── index.php             # entry point — loads controller + index view
│   ├── actions/
│   │   ├── search_student.php
│   │   ├── delete_student.php
│   │   └── export_students.php
│   ├── assets/css/style.css
│   ├── assets/js/script.js
│   └── exports/              # generated CSVs (git-ignored, .gitkeep kept)
├── database.sql              # schema + 5 sample rows
└── docs/screenshots/         # add your PNGs here
```

## Quick start (XAMPP on Windows)

1. Copy this folder to `C:\xampp\htdocs\`, e.g.:
   `C:\xampp\htdocs\Student-Management-System`
2. Start **Apache** + **MySQL** in XAMPP Control Panel.
3. Create + seed the database — pick one:
   - phpMyAdmin → Import → choose `database.sql` → Go, or
   - Shell: `mysql -u root < database.sql`
4. Check `app/models/Database.php` credentials match yours (default: `localhost / student_manager / root / ""`).
5. Open: `http://localhost/Student-Management-System/public/index.php`

## Configuration

`app/models/Database.php`:

```php
private $host = "localhost";
private $dbname = "student_manager";
private $username = "root";
private $password = "";
```

Change these to match your MySQL setup.

## Screenshots

> Replace the placeholders in `docs/screenshots/` with real captures (1920×1080 PNG recommended).

| Home / list | Add student |
|---|---|
| ![Home](docs/screenshots/01-home.png) | ![Add](docs/screenshots/02-add.png) |

| View / edit | Search + export |
|---|---|
| ![View](docs/screenshots/03-view-edit.png) | ![Search](docs/screenshots/04-search-export.png) |

To capture: run the app via XAMPP, screenshot each page, save with the exact filenames above.

## API / actions

| Method | Endpoint | Params | Returns |
|---|---|---|---|
| `GET` | `public/index.php` | — | HTML table |
| `POST` | `public/actions/search_student.php` | `query`, `filter=all\|fullname\|student_id\|email\|nationality\|class\|grade` | `<tr>` rows HTML |
| `POST` | `public/actions/delete_student.php` | `id` | `success` / `error` / `invalid_request` |
| `GET` | `public/actions/export_students.php` | — | CSV download |

## Notes / fixes in this release

- `StudentController::getStudents()` now always returns `array` (was `string` when empty → broke `$students` foreach).
- `index.php` view handles empty state with a `There are currently no students.` row.
- Removed top-level `new Database()/new Student()` side effects from `Student.php` and `StudentController.php`.
- Fixed `create.php` / `edit.php` success checks (`=== true` never matched string messages) and `edit.php` redirect path.

## License

MIT — free for learning / portfolios.

<?php

require_once __DIR__.'/../models/Student.php';

class StudentController
{
    private $studentModel;

    public function __construct($studentModel)
    {
        $this->studentModel = $studentModel;
    }

    public function addStudent($data)
    {
        $student_id = isset($data['student_id']) ? trim($data['student_id']) : "";
        $fullname = isset($data['fullname']) ? trim($data['fullname']) : "";
        $email = isset($data['email']) ? trim($data['email']) : "";
        $class = isset($data['class']) ? trim($data['class']) : "";
        $grade = isset($data['grade']) ? trim($data['grade']) : "";
        $date_of_birth = isset($data['date_of_birth']) ? trim($data['date_of_birth']) : "";
        $address = isset($data['address']) ? trim($data['address']) : "";
        $nationality = isset($data['nationality']) ? trim($data['nationality']) : "";
        $parent_number = isset($data['parent_number']) ? trim($data['parent_number']) : "";
        $health_info = isset($data['health_info']) ? trim($data['health_info']) : "";

        if (empty($student_id) || empty($fullname) || empty($email) || empty($class) || empty($grade)) {
            return "Please fill in all required fields (Student ID, Full Name, Email, Class, Grade).";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }

        if (!empty($grade) && !is_numeric($grade)) {
            return "Invalid grade format.";
        }


        $success = $this->studentModel->addStudent(
            $student_id, $fullname, $email, $class, $grade,
            $date_of_birth, $address, $nationality, $parent_number, $health_info
        );

        return $success ? "The student has been added successfully." : "An error occurred while adding the student.";
    }

    public function getStudents()
    {
        $allStudents = $this->studentModel->getAllStudents();
        return is_array($allStudents) ? $allStudents : [];
    }

    public function getStudent($id)
    {
        $student = $this->studentModel->getStudentById($id);
        return empty($student) ? "This student not found." : $student;
    }

    public function updateStudent($id, $data)
    {
        $student_id = isset($data['student_id']) ? trim($data['student_id']) : null;
        $fullname = isset($data['fullname']) ? trim($data['fullname']) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;
        $class = isset($data['class']) ? trim($data['class']) : null;
        $grade = isset($data['grade']) ? trim($data['grade']) : null;
        $date_of_birth = isset($data['date_of_birth']) ? trim($data['date_of_birth']) : null;
        $address = isset($data['address']) ? trim($data['address']) : null;
        $nationality = isset($data['nationality']) ? trim($data['nationality']) : null;
        $parent_number = isset($data['parent_number']) ? trim($data['parent_number']) : null;
        $health_info = isset($data['health_info']) ? trim($data['health_info']) : null;

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }

        if (!empty($grade) && !is_numeric($grade)) {
            return "Invalid grade format.";
        }


        $success = $this->studentModel->updateStudent(
            $id, $student_id, $fullname, $email, $class, $grade,
            $date_of_birth, $address, $nationality, $parent_number, $health_info
        );

        return $success ? "The student has been updated successfully." : "An error occurred while updating the student.";
    }


    public function deleteStudent($id)
    {
        $delete = $this->studentModel->deleteStudent($id);
        return $delete ? "The student has been deleted successfully." : "An error occurred while deleting the student.";
    }


    public function searchStudent($query, $filter = 'all')
    {
        return $this->studentModel->search($query, $filter);
    }
}

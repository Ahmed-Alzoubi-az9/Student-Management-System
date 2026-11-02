<?php

require_once __DIR__.'/../models/Teacher.php';

class TeacherController
{
    private $teacherModel;

    public function __construct($teacherModel)
    {
        $this->teacherModel = $teacherModel;
    }

    public function addTeacher($data)
    {
        $fullname = isset($data['fullname']) ? trim($data['fullname']) : "";
        $email = isset($data['email']) ? trim($data['email']) : "";
        $phone = isset($data['phone']) ? trim($data['phone']) : "";
        $subject_id = isset($data['subject_id']) && $data['subject_id'] !== '' ? intval($data['subject_id']) : null;

        if (empty($fullname) || empty($email)) {
            return "Please fill in all required fields (Full Name, Email).";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }

        if ($this->teacherModel->emailExists($email)) {
            return "A teacher with email \"{$email}\" already exists.";
        }

        $success = $this->teacherModel->addTeacher($fullname, $email, $phone, $subject_id);

        return $success ? "The teacher has been added successfully." : "An error occurred while adding the teacher.";
    }

    public function getTeachers()
    {
        $allTeachers = $this->teacherModel->getAllTeachers();
        return is_array($allTeachers) ? $allTeachers : [];
    }

    public function getTeacher($id)
    {
        $teacher = $this->teacherModel->getTeacherById($id);
        return empty($teacher) ? "This teacher not found." : $teacher;
    }

    public function updateTeacher($id, $data)
    {
        $fullname = isset($data['fullname']) ? trim($data['fullname']) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;
        $phone = isset($data['phone']) ? trim($data['phone']) : null;
        $subject_id = null;

        if (isset($data['subject_id'])) {
            $subject_id = $data['subject_id'] === '' ? '' : intval($data['subject_id']);
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }

        if (!empty($email) && $this->teacherModel->emailExistsForOther($email, $id)) {
            return "A teacher with email \"{$email}\" already exists.";
        }

        $success = $this->teacherModel->updateTeacher($id, $fullname, $email, $phone, $subject_id);

        return $success ? "The teacher has been updated successfully." : "An error occurred while updating the teacher.";
    }

    public function deleteTeacher($id)
    {
        $delete = $this->teacherModel->deleteTeacher($id);
        return $delete ? "The teacher has been deleted successfully." : "An error occurred while deleting the teacher.";
    }

    public function searchTeacher($query, $filter = 'all')
    {
        return $this->teacherModel->search($query, $filter);
    }
}

<?php

require_once __DIR__.'/../models/Subject.php';

class SubjectController
{
    private $subjectModel;

    public function __construct($subjectModel)
    {
        $this->subjectModel = $subjectModel;
    }

    public function addSubject($data)
    {
        $code = isset($data['code']) ? trim($data['code']) : "";
        $name = isset($data['name']) ? trim($data['name']) : "";
        $description = isset($data['description']) ? trim($data['description']) : "";

        if (empty($code) || empty($name)) {
            return "Please fill in all required fields (Code, Name).";
        }

        if ($this->subjectModel->codeExists($code)) {
            return "A subject with code \"{$code}\" already exists.";
        }

        $success = $this->subjectModel->addSubject($code, $name, $description);

        return $success ? "The subject has been added successfully." : "An error occurred while adding the subject.";
    }

    public function getSubjects()
    {
        $allSubjects = $this->subjectModel->getAllSubjects();
        return is_array($allSubjects) ? $allSubjects : [];
    }

    public function getSubject($id)
    {
        $subject = $this->subjectModel->getSubjectById($id);
        return empty($subject) ? "This subject not found." : $subject;
    }

    public function updateSubject($id, $data)
    {
        $code = isset($data['code']) ? trim($data['code']) : null;
        $name = isset($data['name']) ? trim($data['name']) : null;
        $description = isset($data['description']) ? trim($data['description']) : null;

        $success = $this->subjectModel->updateSubject($id, $code, $name, $description);

        return $success ? "The subject has been updated successfully." : "An error occurred while updating the subject.";
    }

    public function deleteSubject($id)
    {
        $delete = $this->subjectModel->deleteSubject($id);
        return $delete ? "The subject has been deleted successfully." : "An error occurred while deleting the subject.";
    }

    public function searchSubject($query, $filter = 'all')
    {
        return $this->subjectModel->search($query, $filter);
    }
}

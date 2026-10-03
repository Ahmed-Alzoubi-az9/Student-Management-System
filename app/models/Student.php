<?php

class Student
{

    private $conn;



    public function __construct(PDO $db)

    {
        $this->conn = $db;
    }


    public function addStudent($student_id, $fullname, $email, $class, $grade, $date_of_birth, $address, $nationality, $parent_number, $health_info)
    {
        /** @var PDOStatement $stat */
        $stat = $this->conn->prepare("INSERT INTO students (student_id, fullname, email, class, grade, date_of_birth, address, nationality, parent_number, health_info) VALUES(:student_id, :fullname, :email, :class, :grade, :date_of_birth, :address, :nationality, :parent_number, :health_info)");
        $stat->bindParam(':student_id', $student_id);
        $stat->bindParam(':fullname', $fullname);
        $stat->bindParam(':email', $email);
        $stat->bindParam(':class', $class);
        $stat->bindParam(':grade', $grade);
        $stat->bindParam(':date_of_birth', $date_of_birth);
        $stat->bindParam(':address', $address);
        $stat->bindParam(':nationality', $nationality);
        $stat->bindParam(':parent_number', $parent_number);
        $stat->bindParam(':health_info', $health_info);
        return $stat->execute();
    }

    public function getAllStudents()
    {
        $stat = $this->conn->prepare("SELECT * FROM students");
        $stat->execute();
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentById($id)
    {
        $stat = $this->conn->prepare("SELECT * FROM students WHERE id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        $stat->execute();
        return $stat->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, $student_id, $fullname, $email, $class, $grade, $date_of_birth, $address, $nationality, $parent_number, $health_info)
    {
        $fields = [];
        $params = [':id' => $id];

        if ($student_id !== null) {
            $fields[] = "student_id = :student_id";
            $params[':student_id'] = $student_id;
        }
        if ($fullname !== null) {
            $fields[] = "fullname = :fullname";
            $params[':fullname'] = $fullname;
        }
        if ($email !== null) {
            $fields[] = "email = :email";
            $params[':email'] = $email;
        }
        if ($class !== null) {
            $fields[] = "class = :class";
            $params[':class'] = $class;
        }
        if ($grade !== null) {
            $fields[] = "grade = :grade";
            $params[':grade'] = $grade;
        }
        if ($date_of_birth !== null) {
            $fields[] = "date_of_birth = :date_of_birth";
            $params[':date_of_birth'] = $date_of_birth;
        }
        if ($address !== null) {
            $fields[] = "address = :address";
            $params[':address'] = $address;
        }
        if ($nationality !== null) {
            $fields[] = "nationality = :nationality";
            $params[':nationality'] = $nationality;
        }
        if ($parent_number !== null) {
            $fields[] = "parent_number = :parent_number";
            $params[':parent_number'] = $parent_number;
        }
        if ($health_info !== null) {
            $fields[] = "health_info = :health_info";
            $params[':health_info'] = $health_info;
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE students SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteStudent($id)
    {
        $stat = $this->conn->prepare("DELETE FROM students WHERE id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        return $stat->execute();
    }


    public function search($query, $filter = 'all')
    {
        $sql = "SELECT * FROM students";
        $params = [];

        if (!empty($query)) {

            if ($filter === 'all') {
                $sql .= " WHERE student_id LIKE :query
                      OR fullname LIKE :query
                      OR email LIKE :query
                      OR class LIKE :query
                      OR grade LIKE :query
                      OR nationality LIKE :query
                      OR parent_number LIKE :query";
            } else {
                $allowedFilters = ['student_id', 'fullname', 'email', 'class', 'grade', 'nationality'];
                if (in_array($filter, $allowedFilters)) {
                    $sql .= " WHERE $filter LIKE :query";
                }
            }

            $params[':query'] = "%$query%";
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}

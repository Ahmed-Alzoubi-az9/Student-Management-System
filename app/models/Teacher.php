<?php

class Teacher
{
    private $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function addTeacher($fullname, $email, $phone, $subject_id)
    {
        /** @var PDOStatement $stat */
        $stat = $this->conn->prepare("INSERT INTO teachers (fullname, email, phone, subject_id) VALUES(:fullname, :email, :phone, :subject_id)");
        $stat->bindParam(':fullname', $fullname);
        $stat->bindParam(':email', $email);
        $stat->bindParam(':phone', $phone);
        if ($subject_id === null || $subject_id === '') {
            $stat->bindValue(':subject_id', null, PDO::PARAM_NULL);
        } else {
            $stat->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        }
        return $stat->execute();
    }

    public function getAllTeachers()
    {
        $stat = $this->conn->prepare("SELECT t.*, s.code AS subject_code, s.name AS subject_name
                                      FROM teachers t
                                      LEFT JOIN subjects s ON s.id = t.subject_id
                                      ORDER BY t.fullname");
        $stat->execute();
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeacherById($id)
    {
        $stat = $this->conn->prepare("SELECT t.*, s.code AS subject_code, s.name AS subject_name
                                      FROM teachers t
                                      LEFT JOIN subjects s ON s.id = t.subject_id
                                      WHERE t.id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        $stat->execute();
        return $stat->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists($email)
    {
        $stat = $this->conn->prepare("SELECT id FROM teachers WHERE email=:email LIMIT 1");
        $stat->bindParam(':email', $email);
        $stat->execute();
        return (bool) $stat->fetch();
    }

    public function emailExistsForOther($email, $id)
    {
        $stat = $this->conn->prepare("SELECT id FROM teachers WHERE email=:email AND id<>:id LIMIT 1");
        $stat->bindParam(':email', $email);
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        $stat->execute();
        return (bool) $stat->fetch();
    }

    public function updateTeacher($id, $fullname, $email, $phone, $subject_id)
    {
        $fields = [];
        $params = [':id' => $id];

        if ($fullname !== null) {
            $fields[] = "fullname = :fullname";
            $params[':fullname'] = $fullname;
        }
        if ($email !== null) {
            $fields[] = "email = :email";
            $params[':email'] = $email;
        }
        if ($phone !== null) {
            $fields[] = "phone = :phone";
            $params[':phone'] = $phone;
        }
        if ($subject_id !== null) {
            $fields[] = "subject_id = :subject_id";
            if ($subject_id === '') {
                $params[':subject_id'] = null;
            } else {
                $params[':subject_id'] = $subject_id;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE teachers SET " . implode(', ', $fields) . " WHERE id = :id");
        return $stmt->execute($params);
    }

    public function deleteTeacher($id)
    {
        $stat = $this->conn->prepare("DELETE FROM teachers WHERE id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        return $stat->execute();
    }

    public function search($query, $filter = 'all')
    {
        $sql = "SELECT t.*, s.code AS subject_code, s.name AS subject_name
                FROM teachers t
                LEFT JOIN subjects s ON s.id = t.subject_id";
        $params = [];

        if (!empty($query)) {
            if ($filter === 'all') {
                $sql .= " WHERE t.fullname LIKE :query
                      OR t.email LIKE :query
                      OR t.phone LIKE :query
                      OR s.code LIKE :query
                      OR s.name LIKE :query";
            } else {
                $allowedFilters = ['fullname', 'email', 'phone'];
                if (in_array($filter, $allowedFilters)) {
                    $sql .= " WHERE t.$filter LIKE :query";
                }
            }

            $params[':query'] = "%$query%";
        } else {
            $sql .= " ORDER BY t.fullname";
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

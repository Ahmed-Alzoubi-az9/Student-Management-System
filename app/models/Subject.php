<?php

class Subject
{
    private $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function addSubject($code, $name, $description)
    {
        /** @var PDOStatement $stat */
        $stat = $this->conn->prepare("INSERT INTO subjects (code, name, description) VALUES(:code, :name, :description)");
        $stat->bindParam(':code', $code);
        $stat->bindParam(':name', $name);
        $stat->bindParam(':description', $description);
        return $stat->execute();
    }

    public function getAllSubjects()
    {
        $stat = $this->conn->prepare("SELECT * FROM subjects ORDER BY code");
        $stat->execute();
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubjectById($id)
    {
        $stat = $this->conn->prepare("SELECT * FROM subjects WHERE id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        $stat->execute();
        return $stat->fetch(PDO::FETCH_ASSOC);
    }

    public function codeExists($code)
    {
        $stat = $this->conn->prepare("SELECT id FROM subjects WHERE code=:code LIMIT 1");
        $stat->bindParam(':code', $code);
        $stat->execute();
        return (bool) $stat->fetch();
    }

    public function updateSubject($id, $code, $name, $description)
    {
        $fields = [];
        $params = [':id' => $id];

        if ($code !== null) {
            $fields[] = "code = :code";
            $params[':code'] = $code;
        }
        if ($name !== null) {
            $fields[] = "name = :name";
            $params[':name'] = $name;
        }
        if ($description !== null) {
            $fields[] = "description = :description";
            $params[':description'] = $description;
        }

        if (empty($fields)) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE subjects SET " . implode(', ', $fields) . " WHERE id = :id");
        return $stmt->execute($params);
    }

    public function deleteSubject($id)
    {
        $stat = $this->conn->prepare("DELETE FROM subjects WHERE id=:id");
        $stat->bindParam(':id', $id, PDO::PARAM_INT);
        return $stat->execute();
    }

    public function search($query, $filter = 'all')
    {
        $sql = "SELECT * FROM subjects";
        $params = [];

        if (!empty($query)) {
            if ($filter === 'all') {
                $sql .= " WHERE code LIKE :query
                      OR name LIKE :query
                      OR description LIKE :query";
            } else {
                $allowedFilters = ['code', 'name', 'description'];
                if (in_array($filter, $allowedFilters)) {
                    $sql .= " WHERE $filter LIKE :query";
                }
            }

            $params[':query'] = "%$query%";
        } else {
            $sql .= " ORDER BY code";
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

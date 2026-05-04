<?php
declare(strict_types=1);

namespace App\Library;

class StudentRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    
    public function findAll(): array
    {
        $sql = 'SELECT * FROM students ORDER BY name';
        $result = $this->connection->getConnection()->query($sql);
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $student = new Student($row['name']);
            $student->setId((int)$row['student_id']);
            $students[] = $student;
        }
        return $students;
    }
    public function findById(int $id): ?Student
    {
        $sql = 'SELECT * FROM students WHERE student_id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            return null;
        }
        $student = new Student($row['name']);
        $student->setId((int)$row['student_id']);
        return $student;
    }

    public function getConnection(): mysqli
    {
        return $this->connection->getConnection();
    }
}
?>


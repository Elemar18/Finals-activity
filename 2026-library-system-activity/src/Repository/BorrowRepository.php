<?php

declare(strict_types=1);

namespace App\Library;

use DateTime;
use DateInterval;

class BorrowRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function borrowBook(int $studentId, int $bookId, int $days): int
    {
        $borrowDate = new DateTime();
        $dueDate = (clone $borrowDate)->add(new DateInterval('P' . $days . 'D'));

        $sql = 'INSERT INTO borrow_records (student_id, book_id, borrow_date, due_date, status) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->connection->prepare($sql);
$borrowStr = $borrowDate->format('Y-m-d');
$dueStr = $dueDate->format('Y-m-d');
$status = LibraryConfig::STATUS_BORROWED;
$stmt->bind_param('iisss', $studentId, $bookId, $borrowStr, $dueStr, $status);
        $stmt->execute();

        return $this->connection->insertId();
    }

    public function returnBook(int $recordId): float
    {
        $sql = 'SELECT * FROM borrow_records WHERE record_id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('i', $recordId);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_assoc();

        if (!$record) {
            throw new DatabaseException('Record not found');
        }

        $due = new DateTime($record['due_date']);
        $today = new DateTime();
        $interval = $today->diff($due);
        $daysOverdue = max(0, (int)$interval->format('%r%a'));

        $fine = $daysOverdue * LibraryConfig::DAILY_FINE_RATE;

        $returnDate = $today->format('Y-m-d');
        $sql2 = 'UPDATE borrow_records SET return_date = ?, fine_amount = ?, status = ? WHERE record_id = ?';
        $stmt2 = $this->connection->prepare($sql2);
$status = LibraryConfig::STATUS_RETURNED;
$stmt2->bind_param('sdsi', $returnDate, $fine, $status, $recordId);
        $stmt2->execute();

        return $fine;
    }

    public function getOverdueBooks(): array
    {
        $today = date('Y-m-d');
        $sql = 'SELECT br.*, b.title, s.name 
                FROM borrow_records br 
                JOIN books b ON br.book_id = b.book_id 
                JOIN students s ON br.student_id = s.student_id 
                WHERE br.due_date < ? AND br.status = ?';
        $stmt = $this->connection->prepare($sql);
$status = LibraryConfig::STATUS_BORROWED;
$stmt->bind_param('ss', $today, $status);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

public function getConnection(): mysqli
    {
        return $this->connection->getConnection();
    }
}

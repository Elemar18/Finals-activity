<?php
declare(strict_types=1);

namespace App\Library;

use mysqli;

class BookRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function addBook(string $title, string $author, int $year, string $genre): int
    {
        $sql = 'INSERT INTO books (title, author, year, genre) VALUES (?, ?, ?, ?)';
        $stmt = $this->connection->prepare($sql);
        $titleVar = $title;
        $authorVar = $author;
        $yearVar = $year;
        $genreVar = $genre;
        $stmt->bind_param('ssis', $titleVar, $authorVar, $yearVar, $genreVar);
        $stmt->execute();
        return $this->connection->insertId();
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM books ORDER BY title';
        $result = $this->connection->getConnection()->query($sql);
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $book = new Book($row['title'], $row['author'], (int)$row['year'], $row['genre']);
            $book->setId((int)$row['book_id']);
            $books[] = $book;
        }
        return $books;
    }

    /**
     * Find book by ID.
     */
    public function findById(int $id): ?Book
    {
        $sql = 'SELECT * FROM books WHERE book_id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            return null;
        }
        $book = new Book($row['title'], $row['author'], (int)$row['year'], $row['genre']);
        $book->setId((int)$row['book_id']);
        return $book;
    }

    /**
     * Get books not currently borrowed.
     */
    public function getAvailableBooks(): array
    {
        $sql = 'SELECT DISTINCT b.* FROM books b 
                LEFT JOIN borrow_records br ON b.book_id = br.book_id AND br.status = ?
                WHERE br.record_id IS NULL 
                ORDER BY b.title';
        $stmt = $this->connection->prepare($sql);
        $statusBorrowed = LibraryConfig::STATUS_BORROWED;
        $stmt->bind_param('s', $statusBorrowed);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $book = new Book($row['title'], $row['author'], (int)$row['year'], $row['genre']);
            $book->setId((int)$row['book_id']);
            $books[] = $book;
        }
        return $books;
    }

    public function getConnection(): mysqli
    {
        return $this->connection->getConnection();
    }
}
?>


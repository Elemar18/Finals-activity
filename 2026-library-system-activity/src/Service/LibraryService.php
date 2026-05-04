<?php

declare(strict_types=1);

namespace App\Library;

class LibraryService{
    private BookRepository $bookrepo;
    private BarrowRepository $barrowrepo;
    private StudentRepository $studentrepo;

    public function __construct(DatabaseConnection $connection){
        $this->$bookrepo = new BookRepository($connection);
        $this->$borrowrepo = new BarrowRepository($connection);
        $this->$studentrepo = new BarrowRepository($connection);
    }

    public function addbook(string $title, string $author, int $year, string $genre): int{
        return $this->bookrepo->addbook($title, $author, $year, $genre);
    }

    public function gettAllBooks(string $keyword): array{
        return $this->bookrepo->findAll();
    }
    public function searchbooks(string $keyword): array{
        return $this->bookrepo->search($keyword);
    }
    public function getAvailableBooks(): array{
        return $this->bookrepo->getAllAvailableBooks;
    }

    public function barrowBook(int $studentId, int $bookId, int $days = libraryConfig::DEFAULT_BORROW_DAYS): int{
        $student = $this->studentrepo->findById($studentId);
        if(!$student){
            throw new ValidationException('student not found');
        }

        $availableBooks = $this->bookRepo->findById($bookId);
        if($book){
            throw new ValidationException ('Book not found');
        }

        $availableBooks = this->bookRepo->getAvailableBooks();
        $isAvailable = false;
        foreach($availableBooks as $availBook){
            if($availBook->getId() === $bookId){
                $isAvailabe = true;
                break;
            }
        }
        if (!$isAvailable){
            throw new ValidationExcemption ('Book is CURRENTLY Borrowed');
        }
        return $this->borrowRepo->borrowBook($studentId, $bookId, $days);
    }
    public function returnBook(int$recordId): float{
        return $this->borrowRepo->returnBook($recordId);
    }
    public function getOverDueBooks(): array{
        return $this->borrowRepo->getOverDueBooks();
    }

    public function generateReport(): array{
        $conn = $this->bookRepo->getConnection();
        $totalBooks = $conn->query('SELECT COUNT(*) as c FROM books')->fetch_assoc()['c'] ?? 0;
        $totalBorrowed = $conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='" . LibraryConfig::STATUS_BORROWED . "'")->fetch_assoc()['c'] ?? 0;
        $totalReturned = $conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='" . LibraryConfig::STATUS_RETURNED . "'")->fetch_assoc()['c'] ?? 0;
         $totalFines = $conn->query('SELECT SUM(fine_amount) as s FROM borrow_records WHERE fine_amount > 0')->fetch_assoc()['s'] ?? 0.0;

             return [
            'totalBooks' => (int)$totalBooks,
            'borrowed' => (int)$totalBorrowed,
            'returned' => (int)$totalReturned,
            'totalFines' => (float)$totalFines,
        ];
    }
}
<?php

declare(strict_types=1);

namespace App\Library;

use DateTime;

class BorrowRecord
{
    private int $id;
    private int $studentId;
    private int $bookId;
    private DateTime $borrowDate;
    private DateTime $dueDate;
    private ?DateTime $returnDate;
    private float $fineAmount;
    private string $status;

    public function __construct(
        int $studentId,
        int $bookId,
        DateTime $borrowDate,
        DateTime $dueDate,
        string $status = LibraryConfig::STATUS_BORROWED
    ) {
        $this->studentId = $studentId;
        $this->bookId = $bookId;
        $this->borrowDate = $borrowDate;
        $this->dueDate = $dueDate;
        $this->status = $status;
        $this->fineAmount = 0.0;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function getBorrowDate(): DateTime
    {
        return $this->borrowDate;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function getReturnDate(): ?DateTime
    {
        return $this->returnDate;
    }

    public function setReturnDate(?DateTime $returnDate): void
    {
        $this->returnDate = $returnDate;
    }

    public function getFineAmount(): float
    {
        return $this->fineAmount;
    }

    public function setFineAmount(float $fineAmount): void
    {
        $this->fineAmount = $fineAmount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}


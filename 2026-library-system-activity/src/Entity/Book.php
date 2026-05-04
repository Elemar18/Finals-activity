<?php

declare(strict_types=1);

namespace App\Library;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private int $year;
    private string $genre;

    public function __construct(string $title, string $author, int $year, string $genre)
    {
        if ($year < 1000 || $year > (int)date('Y') + 1) {
            throw new ValidationException('Invalid publication year: ' . $year);
        }

        $this->title = trim($title);
        $this->author = trim($author);
        $this->year = $year;
        $this->genre = trim($genre);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }
}


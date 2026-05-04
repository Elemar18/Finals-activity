<?php

declare(strict_types=1);

namespace App\Library;

class Student
{
    private int $id;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = trim($name);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}


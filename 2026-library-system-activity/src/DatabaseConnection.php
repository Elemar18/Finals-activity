<?php

declare(strict_types=1);

namespace App\Library;

use mysqli;
use RuntimeException;

/**
 * Manages MySQL database connections.
 *
 * @author Your Name
 * @since 2026-01-01
 */
class DatabaseConnection
{
    private mysqli $connection;
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    public function __construct(DatabaseConfig $config)
    {
        $this->host = $config::HOST;
        $this->username = $config::USERNAME;
        $this->password = $config::PASSWORD;
        $this->database = $config::DATABASE;

        $this->connect();
    }

    private function connect(): void
    {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_error) {
            throw new RuntimeException(
                'Database connection failed: ' . $this->connection->connect_error
            );
        }

        $this->connection->set_charset('utf8mb4');
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

public function prepare(string $query): ?\mysqli_stmt
    {
        $stmt = $this->connection->prepare($query);
        return $stmt;
    }

    public function insertId(): int
    {
        return (int) $this->connection->insert_id;
    }

    public function escape(string $string): string
    {
        return $this->connection->real_escape_string($string);
    }
}


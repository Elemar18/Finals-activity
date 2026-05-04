# Student Library Management System

A refactored OOP PHP application for managing library books, borrow records, and overdue fines. Built following PSR-12 coding standards.

## Author
- Your Name

## Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Git

## Installation
1. Clone the repository
2. Import `database/schema.sql` into MySQL (create if needed)
3. Copy `.env.example` to `.env` and configure database credentials
4. Run `composer install` (optional)

## File Structure
```
src/
├── Config/          # Configuration constants
├── Entity/          # Data models
├── Repository/      # Database access layer
├── Service/         # Business logic
├── Exception/       # Custom exceptions
└── View/            # HTML templates
public/              # Web entry point
```

## PSR-12 Compliance
- `declare(strict_types=1);`
- 4-space indentation
- Namespaces `App\\Library`
- Prepared statements
- Type declarations everywhere
jddjdjdjj
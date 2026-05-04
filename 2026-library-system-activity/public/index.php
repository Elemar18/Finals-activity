<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/DatabaseConnection.php';
require_once __DIR__ . '/../src/Config/DatabaseConfig.php';
require_once __DIR__ . '/../src/Config/LibraryConfig.php';
require_once __DIR__ . '/../src/Repository/BookRepository.php';
require_once __DIR__ . '/../src/Repository/BorrowRepository.php';
require_once __DIR__ . '/../src/Repository/StudentRepository.php';
require_once __DIR__ . '/../src/Entity/Book.php';
require_once __DIR__ . '/../src/Entity/BorrowRecord.php';
require_once __DIR__ . '/../src/Entity/Student.php';
require_once __DIR__ . '/../src/Service/LibraryService.php';


use App\Library\{ 
    DatabaseConfig, 
    LibraryConfig, 
    LibraryService, 
    DatabaseException, 
    ValidationException,
    DatabaseConnection
};

try {
$config = new DatabaseConfig();
$connection = new DatabaseConnection($config);
    $service = new LibraryService($connection);
    $action = $_GET['act'] ?? 'list';

    ob_start();

    switch ($action) {
        case 'list':
            $books = $service->getAllBooks();
            include __DIR__ . '/../src/View/book_list.php';
            break;

        case 'add':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookId = $service->addBook(
                    $_POST['title'] ?? '',
                    $_POST['author'] ?? '',
                    (int)($_POST['year'] ?? 0),
                    $_POST['genre'] ?? ''
                );
                header('Location: ?act=list');
                exit;
            }
            // Show add form (simple)
            echo '<h1>Add Book</h1><form method="post"><p>Title: <input name="title"></p><p>Author: <input name="author"></p><p>Year: <input name="year" type="number"></p><p>Genre: <input name="genre"></p><button>Add</button></form><a href="?act=list">Back</a>';
            break;

        case 'borrow':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $recordId = $service->borrowBook(
                        (int)($_POST['student_id'] ?? 0),
                        (int)($_POST['book_id'] ?? 0),
                        (int)($_POST['days'] ?? LibraryConfig::DEFAULT_BORROW_DAYS)
                    );
                    header('Location: ?act=list&msg=success');
                    exit;
                } catch (ValidationException $e) {
                    $error = $e->getMessage();
                }
            }

            $students = $service->getStudents();
            $availableBooks = $service->getAvailableBooks();
            $selectedBook = null;
            $bookId = (int)($_GET['book_id'] ?? 0);
            if ($bookId > 0) {
                $bookRepo = new App\Library\BookRepository($connection);
                $selectedBook = $bookRepo->findById($bookId);
                if (!$selectedBook) {
                    $error = 'Book not found';
                }
            }
            include __DIR__ . '/../src/View/borrow_form.php';
            break;

        case 'return':
            if (isset($_GET['rid'])) {
                $fine = $service->returnBook((int)$_GET['rid']);
                echo "<p>Book returned. Fine: $" . number_format($fine, 2) . "</p>";
            }
            header('Location: ?act=list');
            break;

        case 'report':
            $report = $service->generateReport();
            $overdues = $service->getOverdueBooks();
            include __DIR__ . '/../src/View/report_view.php';
            break;

        case 'search':
            $keyword = $_GET['kw'] ?? '';
            $books = $service->searchBooks($keyword);
            include __DIR__ . '/../src/View/book_list.php'; // Reuse
            break;

        default:
            $books = $service->getAllBooks();
            include __DIR__ . '/../src/View/book_list.php';
            break;
    }

} catch (DatabaseException | ValidationException $e) {
    echo '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>';
} catch (Throwable $e) {
    echo '<h1>Unexpected Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>';
}

$content = ob_get_clean();
echo $content;


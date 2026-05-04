<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Book</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
        .book-info { background: #f0f8ff; padding: 15px; border-left: 4px solid #2196F3; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Borrow Book</h1>
    
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
        <p class="success">Book borrowed successfully!</p>
    <?php endif; ?>

    <?php if ($selectedBook): ?>
        <div class="book-info">
            <strong>Selected Book:</strong> <?= htmlspecialchars($selectedBook->getTitle()) ?> by <?= htmlspecialchars($selectedBook->getAuthor()) ?> (<?= $selectedBook->getYear() ?>)
        </div>
    <?php endif; ?>

    <form method="post" action="?act=borrow">
        <label for="student_id">Student:
            <select name="student_id" id="student_id" required>
                <option value="">Select Student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student->getId() ?>"><?= htmlspecialchars($student->getName()) ?> (ID: <?= $student->getId() ?>)</option>
                <?php endforeach; ?>
            </select>
        </label>

        <label for="book_id">Book:
            <select name="book_id" id="book_id" required>
                <option value="">Select Available Book</option>
                <?php foreach ($availableBooks as $book): ?>
                    <option value="<?= $book->getId() ?>" <?= ($selectedBook && $selectedBook->getId() === $book->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($book->getTitle()) ?> by <?= htmlspecialchars($book->getAuthor()) ?> (ID: <?= $book->getId() ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label for="days">Borrow Days:
            <input type="number" name="days" id="days" value="<?= LibraryConfig::DEFAULT_BORROW_DAYS ?>" min="1" max="30" required>
        </label>

        <button type="submit">Borrow Book</button>
    </form>

    <p><a href="?act=list">Back to Books</a></p>
</body>
</html>


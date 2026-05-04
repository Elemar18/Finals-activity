<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Books</title>
    <style>table {border-collapse: collapse; width: 100%;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}</style>
</head>
<body>
    <h1>Library Books</h1>
    <p><a href="?act=add">Add Book</a> | <a href="?act=report">Report</a></p>
    
<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): 
                $status = 'Available';
            ?>
            <tr>
                <td><?= htmlspecialchars((string)$book->getId()) ?></td>
                <td><?= htmlspecialchars($book->getTitle()) ?></td>
                <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                <td><?= htmlspecialchars((string)$book->getYear()) ?></td>
                <td><?= htmlspecialchars($book->getGenre()) ?></td>
                <td><?= htmlspecialchars($status) ?></td>
                <td>
                    <a href="?act=borrow&book_id=<?= $book->getId() ?>" style="background: #2196F3; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;">Borrow</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>


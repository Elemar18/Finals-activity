<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Report</title>
</head>
<body>
    <h1>Library Report</h1>
    <p>Total Books: <?= $report['totalBooks'] ?></p>
    <p>Currently Borrowed: <?= $report['borrowed'] ?></p>
    <p>Returned: <?= $report['returned'] ?></p>
    <p>Total Fines: $<?= number_format($report['totalFines'], 2) ?></p>
    
    <h2>Overdue Books</h2>
    <table>
        <thead>
            <tr><th>Record ID</th><th>Student</th><th>Book</th><th>Due Date</th></tr>
        </thead>
        <tbody>
            <?php foreach ($overdues as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['record_id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['due_date']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="?act=list">Back to Books</a></p>
</body>
</html>


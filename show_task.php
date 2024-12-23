<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid task ID");
}

$query = "SELECT * FROM tasks WHERE id = $1";
$result = pg_query_params($conn, $query, array($id));

if (!$result || pg_num_rows($result) == 0) {
    die("Task not found");
}

$task = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Task Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>Task ID</th>
            <td><?= $task['id']; ?></td>
        </tr>
        <tr>
            <th>Task Name</th>
            <td><?= htmlspecialchars($task['task']); ?></td>
        </tr>
        <tr>
            <th>Priority</th>
            <td><?= $task['priority']; ?></td>
        </tr>
        <tr>
            <th>Due Date</th>
            <td><?= $task['due_date']; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <?php
                $badge_color = ($task['status'] === 'Finished') ? 'success' : 'warning';
                ?>
                <span class="badge bg-<?= $badge_color; ?>"><?= $task['status']; ?></span>
            </td>
        </tr>
        <tr>
            <th>Completion Date</th>
            <td><?= $task['completed_at'] ? $task['completed_at'] : '---'; ?></td>
        </tr>
    </table>

    <a href="index.php" class="btn btn-secondary">Back to Tasks</a>
</div>
</body>
</html>

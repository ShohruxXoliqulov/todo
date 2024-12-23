<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    $query = "INSERT INTO tasks (task, priority, due_date) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($task, $priority, $due_date));

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>
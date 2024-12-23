<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = "Finished";

    $completed_at = date('Y-m-d H:i:s');
    $query = "UPDATE tasks SET status = $1, completed_at = $2 WHERE id = $3";
    $result = pg_query_params($conn, $query, array('Finished', $completed_at, $id));

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $query = "DELETE FROM tasks WHERE id = $1";
    $result = pg_query_params($conn, $query, array($id));

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>
<?php
$host = "localhost";
$port = "5433";
$dbname = "todo";
$user = "postgres";
$password = "Shohrux@2004";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Data bazaga ulanmadi: " . pg_last_error());
}
?>
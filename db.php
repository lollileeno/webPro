<?php

$host = getenv('DB_HOST') ?: "localhost";
$dbname = getenv('DB_NAME') ?: "neon_db";
$user = getenv('DB_USER') ?: "neondb_owner";
$password = getenv('DB_PASS') ?: "";

$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات.");
}
?>

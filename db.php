<?php
// جلب البيانات من متغيرات بيئة Render
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "";
$dbname = getenv('DB_NAME') ?: "saudi_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
// لتجنب مشاكل اللغة العربية في قاعدة البيانات
$conn->set_charset("utf8mb4");
?>

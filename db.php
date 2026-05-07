<?php
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$dbname = 'saudi_db'; 

$conn = new mysqli($host, $username, $password, $dbname);

$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>



$host = 'localhost';
$dbname = 'discover_saudi'; 
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

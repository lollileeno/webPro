<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "saudi_db";
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

// التصحيح هنا: استخدام mysqli بدلاً من myPDO
$conn = new mysqli($servername, $username, $password, $dbname, 3306, $socket);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
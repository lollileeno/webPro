<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']); // Sanitize ID
    $type = $_GET['type'];
    
    if ($type == 'region') {
        $sql = "DELETE FROM regions WHERE id = $id";
    } else {
        $sql = "DELETE FROM places WHERE id = $id";
    }
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?message=" . urlencode("تم حذف المحتوى بنجاح"));
        exit();
    } else {
        echo "خطأ: " . $conn->error;
    }
}
$conn->close();
?>
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'];
    
    try {
        if ($type == 'region') {
            $stmt = $conn->prepare("DELETE FROM regions WHERE id = ?");
        } else {
            $stmt = $conn->prepare("DELETE FROM places WHERE id = ?");
        }
        
        $stmt->execute([$id]);
        
        $_SESSION['message'] = "تم حذف المحتوى بنجاح";
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        // يمكنك توجيه المستخدم لصفحة الداشبورد مع رسالة خطأ أيضاً
        echo "خطأ أثناء الحذف: " . $e->getMessage();
    }
}
$conn = null;
?>

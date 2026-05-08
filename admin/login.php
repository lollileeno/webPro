<?php
session_start();
include '../db.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
        $stmt->execute([$username, $password]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "<p>خطأ في اسم المستخدم أو كلمة المرور</p>";
        }
    } catch (PDOException $e) {
        $error_msg = "<p>خطأ: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="../prostyle.css">
</head>
<body>
    <main>
        <h1>تسجيل الدخول للإدارة</h1>
        <form action="login.php" method="post">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            <div class="form-actions">
                <button type="submit" class="submit-btn">دخول</button>
            </div>
        </form>
        <?php if($error_msg) echo "<div style='color:red;text-align:center;font-weight:bold;margin-top:10px;'>$error_msg</div>"; ?>
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
</body>
</html>

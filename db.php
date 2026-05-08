<?php
// إعدادات الاتصال بقاعدة بيانات Neon
$host = "ep-cool-snowflake-123456.eu-central-1.aws.neon.tech"; // استبدله بالرابط الخاص بك
$dbname = "saudi_db";
$user = "your_neon_user"; // اسم المستخدم في Neon
$password = "your_neon_password"; // كلمة المرور في Neon

// إعداد رابط DSN الخاص بـ PostgreSQL
$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require";

try {
    $conn = new PDO($dsn, $user, $password);
    // تفعيل إظهار الأخطاء للمساعدة في التطوير وتفعيل الحماية
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // جلب البيانات كمصفوفة ترابطية بشكل افتراضي
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة بيانات Neon: " . $e->getMessage());
}
?>

<?php
// إعدادات الاتصال بقاعدة بيانات Neon (PostgreSQL)
// يمكنك استبدال هذه القيم بما يعطيك إياه موقع Neon
$host = "postgresql://neondb_owner:npg_Sjzkav3Wqu6y@ep-shiny-dew-aq6bb3dn-pooler.c-8.us-east-1.aws.neon.tech/neondb?sslmode=require&channel_binding=require"; // من رابط Neon
$dbname = "saudi_db";
$user = "your_neon_user";
$password = "your_neon_password";

// إعداد الـ DSN الخاص بـ PostgreSQL
$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require";

try {
    // إنشاء الاتصال باستخدام PDO
    $conn = new PDO($dsn, $user, $password);
    
    // إعداد PDO لإظهار الأخطاء بشكل استثناءات (Exceptions) للحماية وتسهيل التتبع
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // جلب البيانات على شكل مصفوفة ترابطية افتراضياً
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة بيانات Neon: " . $e->getMessage());
}
?>

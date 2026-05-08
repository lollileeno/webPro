<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // --- بداية نظام التحقق من الصورة ورفعها ---
    $image_name = ""; // المتغير الذي سيحفظ اسم الصورة في قاعدة البيانات

    // التأكد من أن المستخدم قام برفع ملف ولم يحدث خطأ
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        
        // استخراج امتداد الملف
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // الامتدادات المسموح بها
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        // 1. التحقق من الامتداد
        if (in_array($fileExtension, $allowedfileExtensions)) {
            
            // 2. التحقق من أن الملف صورة حقيقية (وليس ملف آخر تم تغيير امتداده)
            $check_image = getimagesize($fileTmpPath);
            if ($check_image !== false) {
                
                // توليد اسم فريد للصورة لمنع تداخل الأسماء
                $newFileName = uniqid('img_', true) . '.' . $fileExtension;
                
                // مسار الحفظ (تأكد أن مجلد images موجود في المسار الرئيسي للمشروع)
                $uploadFileDir = '../images/'; 
                $dest_path = $uploadFileDir . $newFileName;

                // نقل الملف من المسار المؤقت إلى مجلد الصور
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_name = $newFileName; // تم الرفع بنجاح
                } else {
                    $error_msg = "حدث خطأ أثناء حفظ الصورة في المجلد.";
                }
            } else {
                $error_msg = "الملف المرفوع ليس صورة صالحة.";
            }
        } else {
            $error_msg = "عذراً، يُسمح فقط برفع الصور (JPG, JPEG, PNG, GIF, WEBP).";
        }
    } else {
        $error_msg = "الرجاء اختيار صورة لرفعها.";
    }
    // --- نهاية نظام رفع الصورة ---

    // إذا لم تكن هناك أخطاء في الرفع، قم بحفظ البيانات في قاعدة البيانات
    if (empty($error_msg)) {
        if ($type == 'region') {
            $stmt = $conn->prepare("INSERT INTO regions (name, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $description, $image_name);
        } else {
            $region_id = intval($_POST['region_id']);
            $stmt = $conn->prepare("INSERT INTO places (region_id, name, description, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $region_id, $name, $description, $image_name);
        }
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "تم إضافة المحتوى والصورة بنجاح";
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "خطأ في قاعدة البيانات: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محتوى</title>
    <link rel="stylesheet" href="../prostyle.css">
</head>
<body>
    <header>
        <nav>
            <a href="dashboard.php">لوحة التحكم</a>
            <button id="nightModeBtn">الوضع الليلي</button>
            <a href="logout.php">خروج</a>
        </nav>
    </header>
    <main>
        <h1>إضافة محتوى</h1>
        <?php if($error_msg) echo "<p style='color:red; font-weight:bold; text-align:center;'>" . htmlspecialchars($error_msg) . "</p>"; ?>
        
        <form action="add.php" method="post" enctype="multipart/form-data">
            <label for="type">النوع:</label>
            <select id="type" name="type" required>
                <option value="region">منطقة</option>
                <option value="place">مكان</option>
            </select>
            
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">الوصف:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="image">الصورة:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <?php
            $sql = "SELECT * FROM regions";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<label for='region_id'>المنطقة (للأماكن):</label>";
                echo "<select id='region_id' name='region_id'>";
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
                }
                echo "</select>";
            }
            ?>
            <div class="form-actions">
                <button type="submit" class="submit-btn">إضافة</button>
            </div>
        </form>
        
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
    <script src="../scripts.js"></script>
</body>
</html>
<?php $conn->close(); ?>
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
    
    $image_name = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if (in_array($fileExtension, $allowedExtensions)) {
            if (getimagesize($fileTmpPath) !== false) {
                $newFileName = uniqid('img_', true) . '.' . $fileExtension;
                $uploadFileDir = '../images/'; 
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_name = $newFileName;
                } else {
                    $error_msg = "حدث خطأ أثناء حفظ الصورة.";
                }
            } else {
                $error_msg = "الملف ليس صورة صالحة.";
            }
        } else {
            $error_msg = "الصيغ المسموحة: JPG, JPEG, PNG, GIF, WEBP.";
        }
    } else {
        $error_msg = "الرجاء اختيار صورة.";
    }

    if (empty($error_msg)) {
        try {
            if ($type == 'region') {
                $stmt = $conn->prepare("INSERT INTO regions (name, description, image) VALUES (?, ?, ?)");
                $stmt->execute([$name, $description, $image_name]);
            } else {
                $region_id = intval($_POST['region_id']);
                $stmt = $conn->prepare("INSERT INTO places (region_id, name, description, image) VALUES (?, ?, ?, ?)");
                $stmt->execute([$region_id, $name, $description, $image_name]);
            }
            
            $_SESSION['message'] = "تم الإضافة بنجاح";
            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
            $error_msg = "خطأ قاعدة البيانات: " . $e->getMessage();
        }
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
            try {
                $stmt = $conn->query("SELECT * FROM regions");
                $regions = $stmt->fetchAll();
                if (count($regions) > 0) {
                    echo "<label for='region_id'>المنطقة (للأماكن):</label>";
                    echo "<select id='region_id' name='region_id'>";
                    foreach($regions as $row) {
                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
                    }
                    echo "</select>";
                }
            } catch (PDOException $e) {}
            ?>
            <div class="form-actions">
                <button type="submit" class="submit-btn">إضافة المحتوى</button>
            </div>
        </form>
    </main>
    <footer>
        <p>جميع الحقوق محفوظة &copy; اكتشف السعودية</p>
    </footer>
    <script src="../scripts.js"></script>
</body>
</html>
<?php $conn = null; ?>

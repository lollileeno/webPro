<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';

$error_msg = "";

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    echo "لم يتم تحديد المحتوى";
    exit();
}

$id = intval($_GET['id']);
$type = $_GET['type'];

// جلب البيانات الحالية أولاً للحصول على اسم الصورة القديمة
if ($type == 'region') {
    $fetch_sql = "SELECT * FROM regions WHERE id = $id";
} else {
    $fetch_sql = "SELECT * FROM places WHERE id = $id";
}
$fetch_result = $conn->query($fetch_sql);
if ($fetch_result->num_rows > 0) {
    $current_data = $fetch_result->fetch_assoc();
    $image_name = $current_data['image']; // افتراضياً نستخدم الصورة القديمة
} else {
    echo "المحتوى غير موجود";
    exit();
}

// معالجة نموذج التحديث
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // --- نظام التحقق من الصورة الجديدة (في حال تم رفع ملف) ---
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
                    // إذا نجح الرفع، نحدث اسم الصورة (ويمكنك برمجياً حذف الصورة القديمة هنا إذا أردت)
                    $image_name = $newFileName;
                } else {
                    $error_msg = "حدث خطأ أثناء حفظ الصورة الجديدة.";
                }
            } else {
                $error_msg = "الملف المرفوع ليس صورة صالحة.";
            }
        } else {
            $error_msg = "يُسمح فقط بصيغ JPG, JPEG, PNG, GIF, WEBP.";
        }
    }

    // تنفيذ التحديث إذا لم يكن هناك أخطاء
    if (empty($error_msg)) {
        if ($type == 'region') {
            $stmt = $conn->prepare("UPDATE regions SET name=?, description=?, image=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $description, $image_name, $id);
        } else {
            $region_id = intval($_POST['region_id']);
            $stmt = $conn->prepare("UPDATE places SET region_id=?, name=?, description=?, image=? WHERE id=?");
            $stmt->bind_param("isssi", $region_id, $name, $description, $image_name, $id);
        }
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "تم تحديث المحتوى بنجاح";
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "خطأ في التحديث: " . $stmt->error;
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
    <title>تحديث المحتوى</title>
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
        <h1>تحديث: <?php echo htmlspecialchars($current_data['name']); ?></h1>
        
        <?php if($error_msg) echo "<p style='color:red; font-weight:bold;'>" . htmlspecialchars($error_msg) . "</p>"; ?>
        
        <form action="update.php?id=<?php echo $id; ?>&type=<?php echo htmlspecialchars($type); ?>" method="post" enctype="multipart/form-data">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_data['name']); ?>" required>
            
            <label for="description">الوصف:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($current_data['description']); ?></textarea>
            
            <label>الصورة الحالية:</label>
            <div style="margin-bottom: 10px;">
                <img src="../images/<?php echo htmlspecialchars($current_data['image']); ?>" width="100" style="border-radius: 8px;">
                <p style="font-size: 12px; color: var(--text-muted);">اسم الملف: <?php echo htmlspecialchars($current_data['image']); ?></p>
            </div>

            <label for="image">تغيير الصورة (اختياري):</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <?php if ($type == 'place') { ?>
            <label for="region_id">المنطقة التابع لها:</label>
            <select id="region_id" name="region_id" required>
                <?php
                $sql_regions = "SELECT * FROM regions";
                $result_regions = $conn->query($sql_regions);
                while($region = $result_regions->fetch_assoc()) {
                    $selected = ($region['id'] == $current_data['region_id']) ? 'selected' : '';
                    echo "<option value='" . $region['id'] . "' $selected>" . htmlspecialchars($region['name']) . "</option>";
                }
                ?>
            </select>
            <?php } ?>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">تحديث البيانات</button>
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
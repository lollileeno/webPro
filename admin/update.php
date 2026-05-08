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

try {
    if ($type == 'region') {
        $stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM places WHERE id = ?");
    }
    $stmt->execute([$id]);
    $current_data = $stmt->fetch();
    
    if ($current_data) {
        $image_name = $current_data['image'];
    } else {
        echo "المحتوى غير موجود";
        exit();
    }
} catch (PDOException $e) {
    die("خطأ في جلب البيانات: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if (in_array($fileExtension, $allowedExtensions)) {
            if (getimagesize($fileTmpPath) !== false) {
                $newFileName = uniqid('img_', true) . '.' . $fileExtension;
                $dest_path = '../images/' . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_name = $newFileName;
                } else {
                    $error_msg = "خطأ أثناء حفظ الصورة الجديدة.";
                }
            } else {
                $error_msg = "الملف المرفوع ليس صورة.";
            }
        } else {
            $error_msg = "يُسمح فقط بصيغ JPG, JPEG, PNG, GIF, WEBP.";
        }
    }

    if (empty($error_msg)) {
        try {
            if ($type == 'region') {
                $stmt = $conn->prepare("UPDATE regions SET name=?, description=?, image=? WHERE id=?");
                $stmt->execute([$name, $description, $image_name, $id]);
            } else {
                $region_id = intval($_POST['region_id']);
                $stmt = $conn->prepare("UPDATE places SET region_id=?, name=?, description=?, image=? WHERE id=?");
                $stmt->execute([$region_id, $name, $description, $image_name, $id]);
            }
            
            $_SESSION['message'] = "تم تحديث المحتوى بنجاح";
            header("Location: dashboard.php");
            exit();
        } catch (PDOException $e) {
            $error_msg = "خطأ في التحديث: " . $e->getMessage();
        }
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
        <?php if($error_msg) echo "<p style='color:red; font-weight:bold; text-align:center;'>" . htmlspecialchars($error_msg) . "</p>"; ?>
        
        <form action="update.php?id=<?php echo $id; ?>&type=<?php echo htmlspecialchars($type); ?>" method="post" enctype="multipart/form-data">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_data['name']); ?>" required>
            
            <label for="description">الوصف:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($current_data['description']); ?></textarea>
            
            <label>الصورة الحالية:</label>
            <div style="margin-bottom: 10px;">
                <img src="../images/<?php echo htmlspecialchars($current_data['image']); ?>" width="100" style="border-radius: 8px;">
            </div>

            <label for="image">تغيير الصورة (اختياري):</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <?php if ($type == 'place') { ?>
            <label for="region_id">المنطقة التابع لها:</label>
            <select id="region_id" name="region_id" required>
                <?php
                $stmt_regions = $conn->query("SELECT * FROM regions");
                $regions = $stmt_regions->fetchAll();
                foreach($regions as $region) {
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
    </main>
    <footer>
        <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
    </footer>
    <script src="../scripts.js"></script>
</body>
</html>
<?php $conn = null; ?>

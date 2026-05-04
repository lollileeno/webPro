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

// Process Update Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    
    if ($type == 'region') {
        $stmt = $conn->prepare("UPDATE regions SET name=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $description, $image, $id);
    } else {
        $region_id = intval($_POST['region_id']);
        $stmt = $conn->prepare("UPDATE places SET region_id=?, name=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("isssi", $region_id, $name, $description, $image, $id);
    }
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=" . urlencode("تم تحديث المحتوى بنجاح"));
        exit();
    } else {
        $error_msg = "خطأ: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch current data to populate the form
if ($type == 'region') {
    $sql = "SELECT * FROM regions WHERE id = $id";
} else {
    $sql = "SELECT * FROM places WHERE id = $id";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "المحتوى غير موجود";
    exit();
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
            <a href="logout.php">خروج</a>
        </nav>
    </header>
    <main>
        <h1>تحديث المحتوى</h1>
        <?php if($error_msg) echo "<p style='color:red;'>" . htmlspecialchars($error_msg) . "</p>"; ?>
        <form action="update.php?id=<?php echo $id; ?>&type=<?php echo htmlspecialchars($type); ?>" method="post">
            <label for="name">الاسم:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            
            <label for="description">الوصف:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
            
            <label for="image">الصورة:</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required>
            
            <?php if ($type == 'place') { ?>
            <label for="region_id">المنطقة:</label>
            <select id="region_id" name="region_id" required>
                <?php
                $sql_regions = "SELECT * FROM regions";
                $result_regions = $conn->query($sql_regions);
                while($region = $result_regions->fetch_assoc()) {
                    $selected = ($region['id'] == $row['region_id']) ? 'selected' : '';
                    echo "<option value='" . $region['id'] . "' $selected>" . htmlspecialchars($region['name']) . "</option>";
                }
                ?>
            </select>
            <?php } ?>
            
            <button type="submit">تحديث</button>
        </form>
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
</body>
</html>
<?php $conn->close(); ?>
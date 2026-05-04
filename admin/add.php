<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';

$error_msg = "";

// Process form BEFORE any HTML is generated so header() works
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    
    if ($type == 'region') {
        $stmt = $conn->prepare("INSERT INTO regions (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image);
    } else {
        $region_id = intval($_POST['region_id']);
        $stmt = $conn->prepare("INSERT INTO places (region_id, name, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $region_id, $name, $description, $image);
    }
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=" . urlencode("تم إضافة المحتوى بنجاح"));
        exit();
    } else {
        $error_msg = "خطأ: " . $stmt->error;
    }
    $stmt->close();
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
            <a href="logout.php">خروج</a>
        </nav>
    </header>
    <main>
        <h1>إضافة محتوى</h1>
        <?php if($error_msg) echo "<p style='color:red;'>" . htmlspecialchars($error_msg) . "</p>"; ?>
        <form action="add.php" method="post">
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
            <input type="text" id="image" name="image" required>
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
            <button type="submit">إضافة</button>
        </form>
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
</body>
</html>
<?php $conn->close(); ?>
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="../prostyle.css">
</head>
<body>
    <header>
        <nav>
            <a href="add.php">إضافة محتوى</a>
            <a href="logout.php">خروج</a>
        </nav>
    </header>
    <main>
        <h1>لوحة التحكم</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert-popup">
                    <span>' . htmlspecialchars($_SESSION['message']) . '</span>
                    <span class="alert-close">&times;</span>
                  </div>';
            unset($_SESSION['message']);
        }
        ?>
        <h2>المناطق</h2>
        <table>
            <tr>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>الإجراءات</th>
            </tr>
            <?php
            try {
                $stmt = $conn->query("SELECT * FROM regions");
                $regions = $stmt->fetchAll();
                if (count($regions) > 0) {
                    foreach($regions as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td><a href='update.php?id=" . $row["id"] . "&type=region'>تحديث</a> | <a href='delete.php?id=" . $row["id"] . "&type=region' onclick='return confirm(\"هل أنت متأكد؟\")'>حذف</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>لا توجد مناطق مضافة</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='3'>خطأ في جلب البيانات</td></tr>";
            }
            ?>
        </table>
        
        <h2>الأماكن</h2>
        <table>
            <tr>
                <th>الاسم</th>
                <th>المنطقة</th>
                <th>الوصف</th>
                <th>الإجراءات</th>
            </tr>
            <?php
            try {
                $stmt = $conn->query("SELECT places.*, regions.name as region_name FROM places JOIN regions ON places.region_id = regions.id");
                $places = $stmt->fetchAll();
                if (count($places) > 0) {
                    foreach($places as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["region_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td><a href='update.php?id=" . $row["id"] . "&type=place'>تحديث</a> | <a href='delete.php?id=" . $row["id"] . "&type=place' onclick='return confirm(\"هل أنت متأكد؟\")'>حذف</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>لا توجد أماكن مضافة</td></tr>";
                }
            } catch (PDOException $e) {}
            ?>
        </table>
    </main>
    <footer>
        <p>جميع الحقوق محفوظة &copy; اكتشف السعودية</p>
    </footer>
    <script src="../scripts.js"></script>
</body>
</html>
<?php $conn = null; ?>

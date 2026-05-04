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
        if (isset($_GET['message'])) {
            // htmlspecialchars prevents XSS attacks
            echo "<p style='color: green; font-weight: bold;'>" . htmlspecialchars($_GET['message']) . "</p>";
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
            $sql = "SELECT * FROM regions";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "<td><a href='update.php?id=" . $row["id"] . "&type=region'>تحديث</a> | <a href='delete.php?id=" . $row["id"] . "&type=region' onclick='return confirm(\"هل أنت متأكد؟\")'>حذف</a></td>";
                    echo "</tr>";
                }
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
            $sql = "SELECT places.*, regions.name as region_name FROM places JOIN regions ON places.region_id = regions.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["region_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "<td><a href='update.php?id=" . $row["id"] . "&type=place'>تحديث</a> | <a href='delete.php?id=" . $row["id"] . "&type=place' onclick='return confirm(\"هل أنت متأكد؟\")'>حذف</a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
</body>
</html>
<?php $conn->close(); ?>
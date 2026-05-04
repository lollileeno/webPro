<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المنطقة</title>
    <link rel="stylesheet" href="prostyle.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="regions.php">معرض المناطق</a></li>
                <li><a href="details.php">التفاصيل</a></li>
            </ul>
            <button id="nightModeBtn">الوضع الليلي</button>
        </nav>
    </header>
    <main>
        <?php
        include 'db.php';
        if (isset($_GET['region_id'])) {
            // Sanitize the input by casting it to an integer
            $region_id = intval($_GET['region_id']); 
            
            $sql = "SELECT * FROM regions WHERE id = $region_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $region = $result->fetch_assoc();
                echo "<h1>" . htmlspecialchars($region["name"]) . "</h1>";
                echo "<p>" . htmlspecialchars($region["description"]) . "</p>";
                echo "<img src='images/" . htmlspecialchars($region["image"]) . "' alt='" . htmlspecialchars($region["name"]) . "'>";
                
                echo "<h2>الأماكن المهمة</h2>";
                $sql_places = "SELECT * FROM places WHERE region_id = $region_id";
                $result_places = $conn->query($sql_places);
                if ($result_places->num_rows > 0) {
                    while($place = $result_places->fetch_assoc()) {
                        echo "<div class='place'>";
                        echo "<h3>" . htmlspecialchars($place["name"]) . "</h3>";
                        echo "<p>" . htmlspecialchars($place["description"]) . "</p>";
                        echo "<img src='images/" . htmlspecialchars($place["image"]) . "' alt='" . htmlspecialchars($place["name"]) . "'>";
                        echo "</div>";
                    }
                } else {
                    echo "لا توجد أماكن";
                }
            } else {
                echo "المنطقة غير موجودة";
            }
        } else {
            echo "لم يتم تحديد منطقة";
        }
        $conn->close();
        ?>
        <footer>
            <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
        </footer>
    </main>
    <script src="scripts.js"></script>
</body>
</html>

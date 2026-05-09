<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معرض المناطق</title>
    <link rel="stylesheet" href="prostyle.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="regions.php">معرض المناطق</a></li>
            </ul>
            <button id="nightModeBtn">الوضع الليلي</button>
        </nav>
    </header>
    <main>
        <h1>معرض المناطق</h1>
        
        <div class="filter-controls">
            <input type="text" id="searchInput" placeholder="ابحث عن منطقة... (مثال: رياض أو الرياض)">
            <select id="sortSelect">
                <option value="default">الترتيب الافتراضي</option>
                <option value="asc">أبجدي (أ - ي)</option>
                <option value="desc">أبجدي (ي - أ)</option>
            </select>
        </div>

        <div id="gallery">
            <?php
            include 'db.php';
            try {
                $stmt = $conn->query("SELECT * FROM regions");
                $regions = $stmt->fetchAll();
                if (count($regions) > 0) {
                    foreach($regions as $row) {
                        echo "<div class='region' data-name='" . htmlspecialchars($row["name"]) . "' >";
                        echo "<img src='images/" . htmlspecialchars($row["image"]) . "' alt='" . htmlspecialchars($row["name"]) . "'>";
                        echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
                        echo "<a href='details.php?region_id=" . $row["id"] . "'>عرض التفاصيل</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='width: 100%; text-align: center;'>لا توجد مناطق مضافة حتى الآن.</p>";
                }
            } catch (PDOException $e) {}
            $conn = null;
            ?>
        </div>
    </main>
    <footer>
        <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>

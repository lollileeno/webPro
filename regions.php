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
        <input type="text" id="filter" placeholder="ابحث عن منطقة...">
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
                    echo "لا توجد مناطق";
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
    <script>
        document.getElementById('filter').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const regions = document.querySelectorAll('.region');
            regions.forEach(region => {
                const name = region.getAttribute('data-name').toLowerCase();
                if (name.includes(filter)) {
                    region.style.display = 'block';
                } else {
                    region.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

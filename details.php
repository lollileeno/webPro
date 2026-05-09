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
            </ul>
            <button id="nightModeBtn">الوضع الليلي</button>
        </nav>
    </header>
    <main>
        <?php
        include 'db.php';
        
        if (isset($_GET['region_id'])) {
            $region_id = intval($_GET['region_id']); 

            try {
                // جلب المنطقة باستخدام PDO
                $stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
                $stmt->execute([$region_id]);
                $region = $stmt->fetch();

                if ($region) {
                    echo "<h1>" . htmlspecialchars($region["name"]) . "</h1>";
                    echo "<p>" . htmlspecialchars($region["description"]) . "</p>";
                    echo "<img src='images/" . htmlspecialchars($region["image"]) . "' alt='" . htmlspecialchars($region["name"]) . "' class='main-region-img'>";

                    echo "<h2>الأماكن المهمة</h2>";

                    // جلب الأماكن التابعة للمنطقة
                    $stmt_places = $conn->prepare("SELECT * FROM places WHERE region_id = ?");
                    $stmt_places->execute([$region_id]);
                    $places = $stmt_places->fetchAll();

                    echo "<div class='places-list'>"; 
                    if (count($places) > 0) {
                        foreach($places as $place) {
                            echo "<div class='place-card'>";
                            echo "<img src='images/" . htmlspecialchars($place["image"]) . "' alt='" . htmlspecialchars($place["name"]) . "'>";
                            echo "<div class='place-info'>";
                            echo "<h3>" . htmlspecialchars($place["name"]) . "</h3>";
                            echo "<p>" . htmlspecialchars($place["description"]) . "</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>لا توجد أماكن مضافة لهذه المنطقة.</p>";
                    }
                    echo "</div>";

                } else {
                    echo "<p>عذراً، هذه المنطقة غير موجودة.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>خطأ: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>خطأ: لم يتم تحديد المنطقة.</p>";  
        }
        $conn = null;
        ?>
        <div style="text-align: center; margin-top: 40px;">
            <a href="regions.php" class="btn">العودة لمعرض المناطق</a>
        </div>
    </main>
    <footer>
        <p>جميع الحقوق محفوظة © اكتشف السعودية</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>

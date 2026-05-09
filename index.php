<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اكتشف السعودية</title>
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
        <section id="intro">
            <h1>موقع ثقافي تفاعلي للتعريف بالمملكة</h1>
            <p>استكشف مناطق المملكة العربية السعودية وتعرف على أهم المعالم التاريخية والثقافية.</p>
           
           <img src="images/saudi.webp" alt="السعودية" class="hero-img">

            <br>
            <a href="regions.php" class="btn interactive-btn">ابدأ الاستكشاف!</a>
        </section>

        <section class="about-saudi">
            <h2>عن المملكة العربية السعودية</h2>
            <div class="content-wrapper">
                <p>تعد المملكة العربية السعودية قلب العالم الإسلامي، ومهد الحضارات العريقة. تتميز بتنوع جغرافي مذهل يمتد من شواطئ البحر الأحمر الساحرة إلى جبال عسير الخضراء وصحاري الربع الخالي الذهبية.</p>
                
                <p id="moreText" style="display: none;">تشهد المملكة اليوم تحولاً تاريخياً من خلال رؤية 2030، التي تهدف إلى تعزيز مكانتها الاقتصادية والثقافية والسياحية على مستوى العالم، معتمدة على تراثها الغني وشعبها المضياف.</p>
                
                <button id="toggleTextBtn" class="btn text-toggle-btn">عرض المزيد</button>
            </div>
        </section>

        <section class="site-purpose">
            <div class="info-cards">
                <div class="card">
                    <h3>الهدف</h3>
                    <p>.تقديم معلومات عربية موثوقة عن مناطق المملكة وأبرز الوجهات</p>
                </div>
                <div class="card">
                    <h3>المناطق</h3>
                    <p>.معرض تفاعلي يتيح للمستخدم التنقل بين المناطق</p>
                </div>
                <div class="card">
                    <h3>التفاصيل</h3>
                    <p>.صفحة تعرض وصفاً وصوراً ومعلومات تاريخية عن المكان</p>
                </div>
            </div>
        </section>

        <footer>
            <p>جميع الحقوق محفوظة &copy; اكتشف السعودية</p>
        </footer>
    </main>
    <script src="scripts.js"></script>
</body>
</html>

document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // PHASE 1: NIGHT MODE LOGIC
    // ==========================================
    const nightModeBtn = document.getElementById('nightModeBtn');
    
    const updateBtnText = () => {
        if (nightModeBtn) {
            if (document.body.classList.contains('night')) {
                nightModeBtn.innerText = 'الوضع النهاري';
            } else {
                nightModeBtn.innerText = 'الوضع الليلي';
            }
        }
    };

    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night');
    }
    
    updateBtnText();

    if (nightModeBtn) {
        nightModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('night');
            localStorage.setItem('nightMode', document.body.classList.contains('night'));
            updateBtnText();
        });
    }

    // ==========================================
    // PHASE 2: ADMIN ALERT POP-UPS
    // ==========================================
    const alertPopup = document.querySelector('.alert-popup');
    
    if (alertPopup) {
        const closeAlert = () => {
            alertPopup.classList.add('hide-popup'); 
            setTimeout(() => { alertPopup.remove(); }, 500); 
        };

        const timer = setTimeout(closeAlert, 4000);

        const closeBtn = alertPopup.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                clearTimeout(timer); 
                closeAlert();
            };
        }
    }

    // ==========================================
    // PHASE 3: HOME PAGE "SHOW MORE / SHOW LESS"
    // ==========================================
    const toggleTextBtn = document.getElementById('toggleTextBtn');
    const moreText = document.getElementById('moreText');

    if (toggleTextBtn && moreText) {
        toggleTextBtn.addEventListener('click', function() {
            if (moreText.style.display === 'none') {
                // Show the text and dynamically change the button label
                moreText.style.display = 'block';
                toggleTextBtn.innerText = 'عرض أقل';
            } else {
                // Hide the text and dynamically change the button label back
                moreText.style.display = 'none';
                toggleTextBtn.innerText = 'عرض المزيد';
            }
        });
    }

}); 

// ==========================================
    // PHASE 4: REGIONS FILTERING AND SORTING
    // ==========================================
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const gallery = document.getElementById('gallery');

    if (gallery && searchInput && sortSelect) {
        // 1. نحفظ النسخة الأصلية من العناصر لنتمكن من العودة للترتيب الافتراضي
        const originalRegions = Array.from(gallery.querySelectorAll('.region'));

        // دالة إزالة "ال" التعريف
        const removeAl = (str) => {
            let s = str.trim();
            if (s.startsWith('ال')) {
                return s.substring(2);
            }
            return s;
        };

        const updateGallery = () => {
            const query = searchInput.value.trim().toLowerCase();
            const sortOrder = sortSelect.value;
            const cleanQuery = removeAl(query);

            // 2. نبدأ دايماً من النسخة الأصلية لضمان عدم تداخل الترتيبات السابقة
            let filteredRegions = [...originalRegions];

            // 3. التصفية (البحث) [cite: 26]
            filteredRegions = filteredRegions.filter(region => {
                const name = region.getAttribute('data-name');
                const cleanName = removeAl(name);
                return name.includes(query) || cleanName.includes(cleanQuery);
            });

            // 4. الترتيب الأبجدي الذكي (يتجاهل "ال" في المقارنة)
            if (sortOrder === 'asc') {
                filteredRegions.sort((a, b) => {
                    const nameA = removeAl(a.getAttribute('data-name'));
                    const nameB = removeAl(b.getAttribute('data-name'));
                    return nameA.localeCompare(nameB, 'ar');
                });
            } else if (sortOrder === 'desc') {
                filteredRegions.sort((a, b) => {
                    const nameA = removeAl(a.getAttribute('data-name'));
                    const nameB = removeAl(b.getAttribute('data-name'));
                    return nameB.localeCompare(nameA, 'ar');
                });
            }
            // ملاحظة: إذا كان sortOrder هو 'default'، فلن يدخل الشرطين وسيبقى على الترتيب الأصلي

            // 5. مسح المعرض وإعادة رسم البطاقات
            gallery.innerHTML = '';
            if (filteredRegions.length > 0) {
                filteredRegions.forEach(region => gallery.appendChild(region));
            } else {
                gallery.innerHTML = '<p style="width: 100%; text-align: center; font-weight: bold;">لا توجد مناطق مطابقة للبحث.</p>';
            }
        };

        // تشغيل الدالة عند الكتابة في مربع البحث أو عند تغيير الترتيب
        searchInput.addEventListener('input', updateGallery);
        sortSelect.addEventListener('change', updateGallery);
    }

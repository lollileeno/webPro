document.addEventListener('DOMContentLoaded', function() {
    // --- الجزء الخاص بالوضع الليلي ---
    const nightModeBtn = document.getElementById('nightModeBtn');
    
    // دالة لتحديث نص الزر بناءً على الوضع الحالي
    const updateBtnText = () => {
        if (nightModeBtn) {
            if (document.body.classList.contains('night')) {
                nightModeBtn.innerText = 'الوضع النهاري';
            } else {
                nightModeBtn.innerText = 'الوضع الليلي';
            }
        }
    };

    // التحقق من الوضع المحفوظ في المتصفح عند فتح الصفحة
    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night');
    }
    
    // استدعاء الدالة لضبط النص الصحيح أول ما تفتح الصفحة
    updateBtnText();

    if (nightModeBtn) {
        nightModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('night');
            localStorage.setItem('nightMode', document.body.classList.contains('night'));
            
            // تحديث نص الزر فوراً بعد الضغط
            updateBtnText();
        });
    }

    // --- الجزء الخاص بالرسائل (Pop-up) ---
    const alertPopup = document.querySelector('.alert-popup');
    
    if (alertPopup) {
        // دالة الإغلاق الموحدة
        const closeAlert = () => {
            alertPopup.classList.add('hide-popup'); // إضافة كلاس الاختفاء
            setTimeout(() => { alertPopup.remove(); }, 500); // حذفه بعد الأنيميشن
        };

        // 1. المؤقت (Timer): يغلق تلقائياً بعد 4 ثوانٍ
        const timer = setTimeout(closeAlert, 4000);

        // 2. الإغلاق اليدوي: عند الضغط على X
        const closeBtn = alertPopup.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                clearTimeout(timer); // إيقاف المؤقت إذا أغلقها المستخدم يدوياً
                closeAlert();
            };
        }
    }
});

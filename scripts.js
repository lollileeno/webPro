document.addEventListener('DOMContentLoaded', function() {
    // --- الجزء الخاص بالوضع الليلي ---
    const nightModeBtn = document.getElementById('nightModeBtn');
    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night');
    }
    if (nightModeBtn) {
        nightModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('night');
            localStorage.setItem('nightMode', document.body.classList.contains('night'));
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

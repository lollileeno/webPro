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

document.addEventListener('DOMContentLoaded', function() {
    const nightModeBtn = document.getElementById('nightModeBtn');
    
    // Check local storage for user preference on load
    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night');
    }

    if (nightModeBtn) {
        nightModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('night');
            
            // Save preference to localStorage
            const isNightMode = document.body.classList.contains('night');
            localStorage.setItem('nightMode', isNightMode);
        });
    }
});

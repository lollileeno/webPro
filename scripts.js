document.addEventListener('DOMContentLoaded', function() {

 
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


    const toggleTextBtn = document.getElementById('toggleTextBtn');
    const moreText = document.getElementById('moreText');

    if (toggleTextBtn && moreText) {
        toggleTextBtn.addEventListener('click', function() {
            if (moreText.style.display === 'none') {
              
                moreText.style.display = 'block';
                toggleTextBtn.innerText = 'عرض أقل';
            } else {
              
                moreText.style.display = 'none';
                toggleTextBtn.innerText = 'عرض المزيد';
            }
        });
    }

}); 


    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const gallery = document.getElementById('gallery');

    if (gallery && searchInput && sortSelect) {
      
        const originalRegions = Array.from(gallery.querySelectorAll('.region'));

     
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

           
            let filteredRegions = [...originalRegions];

           
            filteredRegions = filteredRegions.filter(region => {
                const name = region.getAttribute('data-name');
                const cleanName = removeAl(name);
                return name.includes(query) || cleanName.includes(cleanQuery);
            });

        
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
          
            gallery.innerHTML = '';
            if (filteredRegions.length > 0) {
                filteredRegions.forEach(region => gallery.appendChild(region));
            } else {
                gallery.innerHTML = '<p style="width: 100%; text-align: center; font-weight: bold;">لا توجد مناطق مطابقة للبحث.</p>';
            }
        };

      
        searchInput.addEventListener('input', updateGallery);
        sortSelect.addEventListener('change', updateGallery);
    }

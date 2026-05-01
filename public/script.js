function showSection(sectionID) {
    const sections = document.querySelectorAll('.content');
    const homesection = document.querySelectorAll('.homecontent');

    sections.forEach(section => {
        section.style.display = 'none';
    });

    homesection.forEach(section => {
        section.style.display = 'none';
    });

    // conceal the troll 
    const trollArea = document.getElementById('troll-area');
    if (trollArea) {
        trollArea.style.display = 'none';
    }

    const activeSection = document.getElementById(sectionID);
    if (activeSection) {
        activeSection.style.display = 'block';
        activeSection.style.animation = 'none';
        activeSection.offsetHeight;
        activeSection.style.animation = 'slideUp 0.4s ease-out';
    }

    updateBreadcrumb(sectionID);
}

function updateBreadcrumb(sectionID) {
    const sep = document.getElementById('breadcrumb-sep');
    const current = document.getElementById('breadcrumb-current');
    const names = {
        'create': '&#10010; Create',
        'read': '&#9783; Read',
        'update': '&#9998; Update',
        'delete': '&#10006; Delete',
        'home': ''
    };
    if (sectionID === 'home' || !names[sectionID]) {
        sep.style.display = 'none';
        current.innerHTML = '';
    } else {
        sep.style.display = 'inline';
        current.innerHTML = names[sectionID] || sectionID;
    }
}

function clearFields() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"], input[type="email"]');
    inputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.value = '';
        }
    });

    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.selectedIndex = 0;
    });

    document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
    document.querySelectorAll('.field-invalid').forEach(el => el.classList.remove('field-invalid'));
}

document.addEventListener('DOMContentLoaded', function () {
    const logo = document.getElementById('logo');
    if (logo) {
        logo.addEventListener('click', function () {
            const contentSections = document.querySelectorAll('.content');
            contentSections.forEach(section => {
                section.style.display = 'none';
            });
            const homeSection = document.querySelector('.homecontent');
            if (homeSection) {
                homeSection.style.display = 'flex';
                homeSection.style.animation = 'none';
                homeSection.offsetHeight;
                homeSection.style.animation = 'scaleIn 0.5s ease-out';
            }
            const trollArea = document.getElementById('troll-area');
            if (trollArea) {
                trollArea.style.display = 'flex';
            }
            updateBreadcrumb('home');
        });
    }

    const brandText = document.querySelector('.brand-text');
    if (brandText) {
        brandText.addEventListener('click', function () {
            logo.click();
        });
        brandText.style.cursor = 'pointer';
    }

    updateGreeting();
    updateClock();
    setInterval(updateClock, 1000);
});


function updateGreeting() {
    const el = document.getElementById('greeting-text');
    if (!el) return;
    const hour = new Date().getHours();
    let greeting;
    if (hour < 12) greeting = '☀️ Good Morning, Admin!';
    else if (hour < 18) greeting = '🌤️ Good Afternoon, Admin!';
    else greeting = '🌙 Good Evening, Admin!';
    el.textContent = greeting;
}

function updateClock() {
    const el = document.getElementById('live-clock');
    if (!el) return;
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateStr = now.toLocaleDateString('en-US', options);
    const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    el.textContent = dateStr + '  •  ' + timeStr;
}


window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);

    function showToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('toast-hidden');
            toast.style.display = 'block';
            toast.style.opacity = '1';
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.classList.add('toast-hidden');
                    toast.style.display = 'none';
                }, 500);
            }, 3000);
        }
    }

    if (urlParams.get('status') === 'success') {
        showToast('success-toast');
        showSection('create');
    }

    if (urlParams.get('status') === 'updated') {
        showToast('update-toast');
        showSection('update');
    }

    if (urlParams.get('status') === 'deleted') {
        showToast('delete-toast');
        showSection('read');
    }

    if (urlParams.get('status')) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            const table = document.getElementById('student-table');
            const rows = table.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                if (row.querySelector('.empty-row') || row.querySelector('.empty-state')) {
                    return;
                }
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(query)) {
                        match = true;
                    }
                });
                row.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            const filterCount = document.getElementById('filter-count');
            if (filterCount) {
                if (query) {
                    filterCount.textContent = visibleCount + ' result' + (visibleCount !== 1 ? 's' : '') + ' found';
                } else {
                    filterCount.textContent = '';
                }
            }
        });
    }
});


function showDeleteModal(id, studentName) {
    const modal = document.getElementById('delete-modal');
    const nameEl = document.getElementById('modal-student-name');
    nameEl.textContent = studentName;
    modal.style.display = 'flex';
    modal.style.animation = 'none';
    modal.offsetHeight;
    modal.style.animation = 'fadeIn 0.3s ease-out';
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.animation = 'fadeIn 0.3s ease-out reverse';
    setTimeout(() => {
        modal.style.display = 'none';
    }, 250);
}

function confirmDelete() {
    const form = document.getElementById('deleteForm');
    if (form) {
        form.submit();
    }
}

document.addEventListener('click', function (e) {
    if (e.target.id === 'delete-modal') {
        closeDeleteModal();
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('delete-modal');
        if (modal && modal.style.display === 'flex') {
            closeDeleteModal();
        }
    }
});


document.addEventListener('DOMContentLoaded', function () {
    
    const createForm = document.getElementById('createForm');
    if (createForm) {
        createForm.addEventListener('submit', function (e) {
            if (!validateForm('create')) {
                e.preventDefault();
            }
        });
    }

    const updateForm = document.getElementById('updateForm');
    if (updateForm) {
        updateForm.addEventListener('submit', function (e) {
            if (!validateForm('update')) {
                e.preventDefault();
            }
        });
    }
});

function validateForm(prefix) {
    let valid = true;

    // Clear previous errors
    document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
    document.querySelectorAll('.field-invalid').forEach(el => el.classList.remove('field-invalid'));

    // Get field references based on prefix
    const isUpdate = prefix === 'update';
    const surnameField = document.getElementById(isUpdate ? 'update_surname' : 'surname');
    const nameField = document.getElementById(isUpdate ? 'update_name' : 'name');
    const emailField = document.getElementById(isUpdate ? 'update_email' : 'email');
    const contactField = document.getElementById(isUpdate ? 'update_contact' : 'contact');

    // Surname required
    if (surnameField && !surnameField.value.trim()) {
        showFieldError(surnameField, isUpdate ? 'err-update-surname' : 'err-surname', 'Surname is required');
        valid = false;
    }

    // Name required
    if (nameField && !nameField.value.trim()) {
        showFieldError(nameField, isUpdate ? 'err-update-name' : 'err-name', 'First name is required');
        valid = false;
    }

    // Email format
    if (emailField && emailField.value.trim()) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value.trim())) {
            showFieldError(emailField, isUpdate ? 'err-update-email' : 'err-email', 'Please enter a valid email address');
            valid = false;
        }
    }

    // Phone number: must be 11 digits
    if (contactField && contactField.value.trim()) {
        const phone = contactField.value.trim();
        const phoneRegex = /^[0-9]{11}$/;
        if (!phoneRegex.test(phone)) {
            showFieldError(contactField, isUpdate ? 'err-update-contact' : 'err-contact', 'Must be exactly 11 digits (e.g. 09123456789)');
            valid = false;
        }
    }

    return valid;
}

function showFieldError(field, errorId, message) {
    field.classList.add('field-invalid');
    const errorEl = document.getElementById(errorId);
    if (errorEl) {
        errorEl.textContent = message;
    }
    // Shake animation
    field.style.animation = 'none';
    field.offsetHeight;
    field.style.animation = 'shake 0.4s ease-out';
}

// KEYBOARD SHORTCUTS

document.addEventListener('keydown', function (e) {
    // Don't trigger shortcuts when typing in inputs
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
        return;
    }

    switch (e.key) {
        case '1':
            showSection('create');
            break;
        case '2':
            showSection('read');
            break;
        case '3':
            showSection('update');
            break;
        case '4':
            showSection('delete');
            break;
        case 'h':
        case 'H':
            document.getElementById('logo').click();
            break;
    }
});

// ============================
// TROLL / RICKROLL
// ============================

function playRickroll() {
    if (document.getElementById('troll-container')) return;

    const trollContainer = document.createElement('div');
    trollContainer.id = 'troll-container';
    trollContainer.style.position = 'fixed';
    trollContainer.style.top = '0';
    trollContainer.style.left = '0';
    trollContainer.style.width = '100vw';
    trollContainer.style.height = '100vh';
    trollContainer.style.zIndex = '9999';
    trollContainer.style.backgroundColor = 'black';
    trollContainer.style.animation = 'fadeIn 0.5s ease-out';
    
    trollContainer.innerHTML = `
        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&controls=0&disablekb=1" title="Rick Astley" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <button id="close-troll" style="position:absolute; top:24px; right:24px; z-index:10000; background:rgba(231, 76, 111, 0.8); color:white; border:none; border-radius:50%; width:40px; height:40px; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.3s ease;">&#10006;</button>
    `;
    
    document.body.appendChild(trollContainer);
    
    const closeBtn = document.getElementById('close-troll');
    closeBtn.addEventListener('mouseover', () => { closeBtn.style.transform = 'scale(1.1)'; });
    closeBtn.addEventListener('mouseout', () => { closeBtn.style.transform = 'scale(1)'; });
    closeBtn.addEventListener('click', function() {
        trollContainer.remove();
    });
}

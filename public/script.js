//function to show selected section
function showSection(sectionID) {
    //initially, select all sections
    const sections = document.querySelectorAll('.content');
    const homesection = document.querySelectorAll('.homecontent');

    //hide the resulting content sections using foreach
    sections.forEach(section => {
        section.style.display = 'none';
    });

    //also hide the home section
    homesection.forEach(section => {
        section.style.display = 'none';
    });

    // Hide troll area when navigating to other sections
    const trollArea = document.getElementById('troll-area');
    if (trollArea) {
        trollArea.style.display = 'none';
    }

    //select the section that would be displayed when clicked
    const activeSection = document.getElementById(sectionID);
    if (activeSection) {
        activeSection.style.display = 'block';
        // Re-trigger animation
        activeSection.style.animation = 'none';
        activeSection.offsetHeight; // force reflow
        activeSection.style.animation = 'slideUp 0.4s ease-out';
    }
}

//function to clear all text and number input fields
function clearFields() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
    inputs.forEach(input => {
        // Don't clear hidden fields
        if (input.type !== 'hidden') {
            input.value = '';
        }
    });
}

//logo click event - hide all sections with class 'content' and show home
document.addEventListener('DOMContentLoaded', function () {
    // Logo click
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
            // Show troll area on home
            const trollArea = document.getElementById('troll-area');
            if (trollArea) {
                trollArea.style.display = 'flex';
            }
        });
    }

    // Brand text click (same as logo)
    const brandText = document.querySelector('.brand-text');
    if (brandText) {
        brandText.addEventListener('click', function () {
            logo.click();
        });
        brandText.style.cursor = 'pointer';
    }
});

//for the toast notifications
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

    // Clean the URL
    if (urlParams.get('status')) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

// Troll button functionality
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

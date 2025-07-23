// Common JavaScript functions for Academic Hub

// Sidebar functionality
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('active');
    if (overlay) {
        overlay.classList.toggle('active');
    }
}

function toggleSidebarSize() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const footer = document.getElementById('footer');
    const toggleIcon = document.getElementById('toggleIcon');
    
    sidebar.classList.toggle('minimized');
    
    if (sidebar.classList.contains('minimized')) {
        mainContent.classList.remove('sidebar-expanded');
        mainContent.classList.add('sidebar-minimized');
        if (footer) {
            footer.classList.remove('sidebar-expanded');
            footer.classList.add('sidebar-minimized');
        }
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-chevron-right text-sm';
        }
    } else {
        mainContent.classList.remove('sidebar-minimized');
        mainContent.classList.add('sidebar-expanded');
        if (footer) {
            footer.classList.remove('sidebar-minimized');
            footer.classList.add('sidebar-expanded');
        }
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-chevron-left text-sm';
        }
    }
}

// Dark mode functionality
function toggleNightMode() {
    const body = document.body;
    const toggle = document.getElementById('nightModeToggle');
    
    body.classList.toggle('dark');
    if (toggle) {
        toggle.classList.toggle('active');
    }
    
    // Save preference
    const isDark = body.classList.contains('dark');
    localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
}

// Initialize dark mode on page load
function initializeDarkMode() {
    const darkMode = localStorage.getItem('darkMode');
    const toggle = document.getElementById('nightModeToggle');
    
    if (darkMode === 'enabled') {
        document.body.classList.add('dark');
        if (toggle) {
            toggle.classList.add('active');
        }
    }
}

// Close sidebar when clicking overlay
function closeSidebarOnOverlay() {
    const overlay = document.getElementById('sidebarOverlay');
    if (overlay) {
        overlay.addEventListener('click', () => {
            toggleSidebar();
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDarkMode();
    closeSidebarOnOverlay();
    
    // Set initial sidebar state for desktop
    if (window.innerWidth >= 1024) {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const footer = document.getElementById('footer');
        
        if (sidebar && mainContent) {
            sidebar.classList.add('active');
            mainContent.classList.add('sidebar-expanded');
            if (footer) {
                footer.classList.add('sidebar-expanded');
            }
        }
    }
    
    // Login page email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('input', function(e) {
            const email = e.target.value;
            if (email && !email.endsWith('@diu.edu.bd')) {
                e.target.setCustomValidity('Email must end with @diu.edu.bd');
                e.target.style.borderColor = '#ef4444';
            } else {
                e.target.setCustomValidity('');
                e.target.style.borderColor = '#1E40AF';
            }
        });
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const footer = document.getElementById('footer');
        
        if (sidebar && mainContent) {
            sidebar.classList.add('active');
            mainContent.classList.add('sidebar-expanded');
            if (footer) {
                footer.classList.add('sidebar-expanded');
            }
        }
    }
});

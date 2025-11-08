// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.getElementById('toast');
    const toastTitle = toast.querySelector('.toast-title');
    const toastMessage = toast.querySelector('.toast-message');
    
    // Set title based on type
    const titles = {
        success: 'Success!',
        error: 'Error!',
        warning: 'Warning!',
        info: 'Information'
    };
    
    toastTitle.textContent = titles[type] || titles.info;
    toastMessage.textContent = message;
    
    // Remove all type classes
    toast.classList.remove('success', 'error', 'warning', 'info');
    
    // Add appropriate type class
    toast.classList.add(type);
    
    // Show toast
    toast.classList.add('show');
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        closeToast();
    }, 5000);
}

// Close toast
function closeToast() {
    const toast = document.getElementById('toast');
    toast.style.animation = 'toastSlide 0.4s ease-out reverse';
    
    setTimeout(() => {
        toast.classList.remove('show');
        toast.style.animation = '';
    }, 400);
}

// Handle delete confirmation
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const confirmDialog = confirm('⚠️ Are you sure you want to delete this contact?\n\nThis action cannot be undone!');
            
            if (confirmDialog) {
                this.submit();
            }
        });
    });
});

// Form validation with enhanced checking
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        
        // Check for empty fields
        if (name === '' || email === '' || phone === '') {
            e.preventDefault();
            showToast('All fields are required! Please fill in the missing information.', 'warning');
            return false;
        }
        
        // Validate name (at least 2 characters)
        if (name.length < 2) {
            e.preventDefault();
            showToast('Name must be at least 2 characters long!', 'warning');
            return false;
        }
        
        // Validate email format
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            e.preventDefault();
            showToast('Please enter a valid email address (e.g., name@example.com)', 'warning');
            return false;
        }
        
        // Validate phone (basic check for numbers)
        const phonePattern = /^[\d\s\-\+\(\)]+$/;
        if (!phonePattern.test(phone) || phone.length < 7) {
            e.preventDefault();
            showToast('Please enter a valid phone number (at least 7 digits)', 'warning');
            return false;
        }
    });
    
    // Real-time validation feedback
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    
    nameInput.addEventListener('blur', function() {
        if (this.value.trim().length > 0 && this.value.trim().length < 2) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '';
        }
    });
    
    emailInput.addEventListener('blur', function() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.value.trim() && !emailPattern.test(this.value.trim())) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '';
        }
    });
    
    phoneInput.addEventListener('blur', function() {
        const phonePattern = /^[\d\s\-\+\(\)]+$/;
        if (this.value.trim() && (!phonePattern.test(this.value.trim()) || this.value.trim().length < 7)) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '';
        }
    });
}

// Clear URL parameters after showing message
if (window.location.search.includes('msg=')) {
    setTimeout(() => {
        const url = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, url);
    }, 100);
}

// Add hover effect for table rows
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus on name input
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('name')?.focus();
    }
    
    // ESC to close toast
    if (e.key === 'Escape') {
        closeToast();
    }
});
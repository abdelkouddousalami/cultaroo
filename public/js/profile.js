// CSRF token setup
document.addEventListener('DOMContentLoaded', function() {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
    let isEditMode = false;

    // Initialize circular progress on page load
    const circularProgress = document.querySelector('.circular-progress');
    if (circularProgress) {
        const percentage = parseInt(circularProgress.getAttribute('data-percentage'));
        const progressCircle = circularProgress.querySelector('.circle-progress');
        
        // Calculate the stroke-dashoffset based on percentage
        const offset = 100 - percentage;
        
        // Animate the progress
        setTimeout(() => {
            progressCircle.style.strokeDashoffset = offset;
        }, 100);
    }

    // Set up event listeners for the forms if they exist
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', handleProfileFormSubmission);
    }

    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', handlePasswordFormSubmission);
    }

    const hostApplicationForm = document.getElementById('host-application-form');
    if (hostApplicationForm) {
        hostApplicationForm.addEventListener('submit', handleHostApplicationSubmission);
    }

    // City input handling for searchable dropdown
    const cityInput = document.getElementById('cityInput');
    const cityHidden = document.getElementById('cityHidden');
    
    if (cityInput && cityHidden) {
        // Update hidden input when user selects a city
        cityInput.addEventListener('change', function() {
            cityHidden.value = this.value;
            
            // Validate the city is in our list
            const datalist = document.getElementById('moroccanCities');
            const options = Array.from(datalist.options).map(opt => opt.value);
            
            if (!options.includes(this.value) && this.value !== '') {
                // Reset if not valid
                this.value = '';
                cityHidden.value = '';
                showAlert('Please select a city from the list', 'error');
            }
        });
        
        // Update hidden input as user types
        cityInput.addEventListener('input', function() {
            cityHidden.value = this.value;
        });
        
        // Also update when focus is lost
        cityInput.addEventListener('blur', function() {
            // Wait a moment to ensure any selection is captured
            setTimeout(() => {
                const datalist = document.getElementById('moroccanCities');
                const options = Array.from(datalist.options).map(opt => opt.value);
                
                if (!options.includes(this.value) && this.value !== '') {
                    this.value = '';
                    cityHidden.value = '';
                    showAlert('Please select a city from the list', 'error');
                }
            }, 200);
        });
    }
});

// Function to update circular progress
function updateCircularProgress(percentage) {
    const circularProgress = document.querySelector('.circular-progress');
    const percentageText = document.querySelector('.percentage-text');
    const progressCircle = document.querySelector('.circle-progress');
    
    if (circularProgress && percentageText && progressCircle) {
        // Update percentage text
        percentageText.textContent = percentage + '%';
        
        // Update data attribute
        circularProgress.setAttribute('data-percentage', percentage);
        
        // Calculate and animate progress
        const offset = 100 - percentage;
        progressCircle.style.strokeDashoffset = offset;
        
        // Add completion animation if 100%
        if (percentage === 100) {
            circularProgress.setAttribute('data-percentage', '100');
        }
    }
}

// Toggle user dropdown menu
function toggleUserMenu() {
    const userMenu = document.getElementById('user-menu');
    const menuButton = document.querySelector('[onclick="toggleUserMenu()"]');
    const menuArrow = document.getElementById('menu-arrow');
    
    userMenu.classList.toggle('hidden');
    
    // Toggle arrow rotation
    if (userMenu.classList.contains('hidden')) {
        menuArrow.classList.remove('rotate-180');
    } else {
        menuArrow.classList.add('rotate-180');
        
        // Force reflow to ensure the menu is visible and properly sized
        void userMenu.offsetWidth;
        
        // Make sure the dropdown is on top of other elements
        userMenu.style.zIndex = '100000';
        
        // Apply 3D transform to help with layering
        userMenu.style.transform = 'translateZ(0)';
        
        // Ensure the menu is properly positioned and visible
        const menuRect = userMenu.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        
        // If menu is going off-screen, adjust position
        if (menuRect.right > viewportWidth) {
            userMenu.style.left = 'auto';
            userMenu.style.right = '0';
        } else {
            // Keep the default left position
            userMenu.style.left = '-8rem';
            userMenu.style.right = 'auto';
        }
    }
    
    // Close notifications if open
    const notificationsMenu = document.getElementById('notifications-menu');
    if (notificationsMenu) notificationsMenu.classList.add('hidden');
    
    // Close mobile menu if open
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) mobileMenu.classList.add('hidden');
}

// Toggle mobile menu
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
    }
    // Close other menus
    document.getElementById('user-menu').classList.add('hidden');
    const notificationsMenu = document.getElementById('notifications-menu');
    if (notificationsMenu) notificationsMenu.classList.add('hidden');
    
    // Reset arrow rotation
    const menuArrow = document.getElementById('menu-arrow');
    if (menuArrow) menuArrow.classList.remove('rotate-180');
}

// Toggle notifications dropdown
function toggleNotifications() {
    const notificationsMenu = document.getElementById('notifications-menu');
    if (notificationsMenu) {
        notificationsMenu.classList.toggle('hidden');
    }
    // Close user menu if open
    document.getElementById('user-menu').classList.add('hidden');
    
    // Reset arrow rotation
    const menuArrow = document.getElementById('menu-arrow');
    if (menuArrow) menuArrow.classList.remove('rotate-180');
    
    // Close mobile menu if open
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) mobileMenu.classList.add('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('user-menu');
    if (!userMenu) return;
    
    const menuButton = event.target.closest('[onclick="toggleUserMenu()"]');
    const menuArrow = document.getElementById('menu-arrow');
    
    if (!menuButton && !userMenu.contains(event.target)) {
        userMenu.classList.add('hidden');
        // Reset arrow rotation
        if (menuArrow) {
            menuArrow.classList.remove('rotate-180');
        }
    }
});

// Close dropdown on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const userMenu = document.getElementById('user-menu');
        const menuArrow = document.getElementById('menu-arrow');
        
        if (userMenu) {
            userMenu.classList.add('hidden');
            if (menuArrow) {
                menuArrow.classList.remove('rotate-180');
            }
        }
        
        // Also close mobile menu if open
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu) mobileMenu.classList.add('hidden');
        
        // Also close notifications if open
        const notificationsMenu = document.getElementById('notifications-menu');
        if (notificationsMenu) notificationsMenu.classList.add('hidden');
    }
});

// Toggle between view and edit modes
function toggleEditMode() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');

    if (!isEditMode) {
        // Switch to edit mode
        viewMode.style.opacity = '0';
        setTimeout(() => {
            viewMode.classList.add('hidden');
            editMode.classList.remove('hidden');
            setTimeout(() => {
                editMode.style.opacity = '1';
            }, 50);
        }, 300);
        
        isEditMode = true;
        
        // Show success message
        showAlert('Edit mode activated. Make your changes and click "Update Profile" to save.', 'success');
    } else {
        // Switch to view mode
        cancelEdit();
    }
}

function cancelEdit() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');

    editMode.style.opacity = '0';
    setTimeout(() => {
        editMode.classList.add('hidden');
        viewMode.classList.remove('hidden');
        setTimeout(() => {
            viewMode.style.opacity = '1';
        }, 50);
    }, 300);
    
    isEditMode = false;
}

// Show alert message
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    
    alertContainer.innerHTML = `
        <div class="alert ${alertClass}">
            ${message}
        </div>
    `;

    // Scroll to top to make sure alert is visible
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Auto-hide after 8 seconds for errors, 5 for success
    const hideTime = type === 'error' ? 8000 : 5000;
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, hideTime);
}

function showSuccessPopup(title, message) {
    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    overlay.style.zIndex = '9999';
    
    // Create modal content
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform scale-95 animate-scale-in shadow-2xl">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">${title}</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">${message}</p>
                <button onclick="this.closest('.fixed').remove()" 
                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                    Great!
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    // Add animation styles if they don't exist
    if (!document.querySelector('#success-popup-styles')) {
        const styles = document.createElement('style');
        styles.id = 'success-popup-styles';
        styles.textContent = `
            @keyframes scale-in {
                from { transform: scale(0.9); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }
            .animate-scale-in {
                animation: scale-in 0.3s ease-out;
            }
        `;
        document.head.appendChild(styles);
    }
    
    // Auto-close after 10 seconds
    setTimeout(() => {
        if (overlay && overlay.parentNode) {
            overlay.remove();
        }
    }, 10000);
}

// Profile form submission
async function handleProfileFormSubmission(e) {
    e.preventDefault();
    
    const formData = new FormData();
    const form = this;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Add CSRF token
    formData.append('_token', csrfToken);
    
    // Only add fields that have values
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.name && input.name !== '_token') {
            if (input.type === 'file') {
                if (input.files.length > 0) {
                    formData.append(input.name, input.files[0]);
                }
            } else if (input.value && input.value.trim() !== '') {
                formData.append(input.name, input.value.trim());
            }
        }
    });
    
    try {
        const response = await fetch('/profile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert(data.message, 'success');
            // Switch back to view mode and reload page to show updated info
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else if (data.errors) {
            // Handle validation errors
            let errorMessage = 'Validation errors:\n';
            for (const field in data.errors) {
                errorMessage += `${field}: ${data.errors[field].join(', ')}\n`;
            }
            showAlert(errorMessage, 'error');
        } else {
            showAlert(data.message || 'Profile update failed', 'error');
        }
    } catch (error) {
        showAlert('An error occurred. Please try again.', 'error');
    }
}

// Password form submission
async function handlePasswordFormSubmission(e) {
    e.preventDefault();
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData(this);
    
    try {
        const response = await fetch('/profile/change-password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert(data.message, 'success');
            this.reset();
        } else {
            showAlert(data.message || 'Password change failed', 'error');
        }
    } catch (error) {
        showAlert('An error occurred. Please try again.', 'error');
    }
}

// Profile picture upload
async function uploadProfilePicture(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('profile_picture', input.files[0]);
        formData.append('_token', csrfToken);

        try {
            const response = await fetch('/profile', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showAlert('Profile picture updated successfully!', 'success');
                location.reload();
            } else {
                showAlert(data.message || 'Failed to update profile picture', 'error');
            }
        } catch (error) {
            showAlert('An error occurred. Please try again.', 'error');
        }
    }
}

// Host Application Modal
function showHostApplicationForm() {
    console.log('Opening host application modal');
    document.getElementById('host-application-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function hideHostApplicationForm() {
    console.log('Closing host application modal');
    document.getElementById('host-application-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Character counter for motivation field
function updateCharacterCount(textarea) {
    const count = textarea.value.length;
    const counter = document.getElementById('motivation-char-count');
    counter.textContent = `${count}/50`;
    
    if (count < 50) {
        counter.classList.add('text-red-500');
        counter.classList.remove('text-green-500');
    } else {
        counter.classList.add('text-green-500');
        counter.classList.remove('text-red-500');
    }
}

// Host application form submission
async function handleHostApplicationSubmission(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Client-side validation
    const motivation = this.querySelector('textarea[name="motivation"]').value;
    const languages = this.querySelectorAll('input[name="languages[]"]:checked');
    const amenities = this.querySelectorAll('input[name="amenities[]"]:checked');
    
    let validationErrors = [];
    
    if (motivation.length < 50) {
        validationErrors.push('Motivation must be at least 50 characters long');
    }
    
    if (languages.length === 0) {
        validationErrors.push('Please select at least one language');
    }
    
    if (amenities.length === 0) {
        validationErrors.push('Please select at least one amenity');
    }
    
    if (validationErrors.length > 0) {
        showAlert('Please fix the following errors:<br><br>' + validationErrors.join('<br>'), 'error');
        return;
    }
    
    // Show immediate feedback
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.textContent = 'Submitting...';
    submitButton.disabled = true;
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch('/host-application', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();

        if (response.ok && data.success) {
            showAlert(data.message, 'success');
            hideHostApplicationForm();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            if (data.errors) {
                let errorMessages = [];
                for (const field in data.errors) {
                    // Make field names more user-friendly
                    const fieldName = field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                    errorMessages.push(`${fieldName}: ${data.errors[field].join(', ')}`);
                }
                showAlert('Please fix the following errors:<br><br>' + errorMessages.join('<br>'), 'error');
            } else {
                showAlert(data.message || 'Application submission failed', 'error');
            }
        }
    } catch (error) {
        // Try to get more specific error information
        let errorMessage = error.message;
        if (error.response) {
            try {
                const errorData = await error.response.json();
                if (errorData.errors) {
                    let errorMessages = [];
                    for (const field in errorData.errors) {
                        const fieldName = field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                        errorMessages.push(`${fieldName}: ${errorData.errors[field].join(', ')}`);
                    }
                    errorMessage = 'Please fix the following errors:<br><br>' + errorMessages.join('<br>');
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (parseError) {
                // Silent fail for parse error
            }
        }
        
        showAlert(`Error: ${errorMessage}`, 'error');
    } finally {
        // Re-enable submit button
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    }
}

// Verification Modal Functions
function openVerificationModal() {
    const modal = document.getElementById('verification-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeVerificationModal() {
    const modal = document.getElementById('verification-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        const form = document.getElementById('verification-form');
        if (form) {
            form.reset();
        }
    }
}

// Handle verification form submission
document.addEventListener('DOMContentLoaded', function() {
    const verificationForm = document.getElementById('verification-form');
    if (verificationForm) {
        verificationForm.addEventListener('submit', handleVerificationSubmission);
    }
});

async function handleVerificationSubmission(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Disable submit button and show loading
    submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...';
    submitButton.disabled = true;
    
    try {
        const formData = new FormData(form);
        
        // Validate file size (5MB limit)
        const fileInput = form.querySelector('input[type="file"]');
        if (fileInput.files[0] && fileInput.files[0].size > 5 * 1024 * 1024) {
            throw new Error('File size must be less than 5MB');
        }
        
        // Validate document type is selected
        const documentType = form.querySelector('input[name="document_type"]:checked');
        if (!documentType) {
            throw new Error('Please select a document type');
        }
        
        // Validate file is selected
        if (!fileInput.files[0]) {
            throw new Error('Please select a document to upload');
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(fileInput.files[0].type)) {
            throw new Error('Please upload a valid file (JPG, PNG, or PDF)');
        }

        const response = await fetch('/verification/submit', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Show success popup
            showSuccessPopup('Verification Submitted Successfully!', 
                'Your verification request has been submitted. We will review it within 24-48 hours and notify you via email.');
            
            // Close modal
            closeVerificationModal();
            
            // Reload page after 3 seconds to show updated status
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } else {
            throw new Error(data.message || 'Failed to submit verification request');
        }
        
    } catch (error) {
        console.error('Verification submission error:', error);
        showAlert(error.message, 'error');
    } finally {
        // Restore button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }
}

// Make functions globally available
window.openVerificationModal = openVerificationModal;
window.closeVerificationModal = closeVerificationModal;

// Enhanced file upload with drag and drop
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.querySelector('.document-upload-area');
    const fileInput = document.querySelector('#file-input');
    
    if (uploadArea && fileInput) {
        // File input change handler
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                updateFileDisplay(this.files[0]);
                updateProgressStep(2);
            }
        });

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        uploadArea.addEventListener('drop', handleDrop, false);
        
        // Make entire upload area clickable
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    }

    // Document type selection handler
    const documentTypeRadios = document.querySelectorAll('input[name="document_type"]');
    documentTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateProgressStep(1);
            }
        });
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        uploadArea.classList.add('drag-over');
        uploadArea.style.borderColor = '#3b82f6';
        uploadArea.style.backgroundColor = '#eff6ff';
    }
    
    function unhighlight() {
        uploadArea.classList.remove('drag-over');
        uploadArea.style.borderColor = '';
        uploadArea.style.backgroundColor = '';
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            const file = files[0];
            
            // Validate file type
            if (!['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'].includes(file.type)) {
                showAlert('Please upload a valid file (JPG, PNG, or PDF)', 'error');
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('File size must be less than 5MB', 'error');
                return;
            }
            
            fileInput.files = files;
            updateFileDisplay(file);
            updateProgressStep(2);
        }
    }
    
    function updateFileDisplay(file) {
        const uploadContent = uploadArea.querySelector('.upload-content');
        if (!uploadContent) return;
        
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        const fileIcon = getFileIcon(file.type);
        
        uploadContent.innerHTML = `
            <div class="flex items-center justify-center space-x-4 p-4 bg-green-50 rounded-lg border-2 border-green-200">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    ${fileIcon}
                </div>
                <div class="text-left">
                    <p class="text-sm font-semibold text-green-800">${file.name}</p>
                    <p class="text-xs text-green-600">${fileSize} MB • ${file.type.split('/')[1].toUpperCase()}</p>
                </div>
                <button type="button" onclick="clearFileSelection()" class="text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
    }
    
    function getFileIcon(fileType) {
        if (fileType === 'application/pdf') {
            return `<svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                    </svg>`;
        } else {
            return `<svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>`;
        }
    }
    
    function updateProgressStep(step) {
        const steps = document.querySelectorAll('#verification-modal .w-8.h-8');
        
        steps.forEach((stepElement, index) => {
            if (index + 1 <= step) {
                stepElement.classList.remove('bg-gray-300', 'text-gray-600');
                stepElement.classList.add('bg-blue-600', 'text-white');
                
                const label = stepElement.nextElementSibling;
                if (label) {
                    label.classList.remove('text-gray-500');
                    label.classList.add('text-blue-600', 'font-medium');
                }
            }
        });
    }
});

// Function to clear file selection
function clearFileSelection() {
    const fileInput = document.querySelector('#file-input');
    const uploadArea = document.querySelector('.document-upload-area');
    
    if (fileInput) {
        fileInput.value = '';
    }
    
    if (uploadArea) {
        const uploadContent = uploadArea.querySelector('.upload-content');
        if (uploadContent) {
            uploadContent.innerHTML = `
                <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Drop your file here</h3>
                <p class="text-gray-600 mb-4">
                    or <button type="button" onclick="document.getElementById('file-input').click()" class="text-blue-600 hover:text-blue-700 font-medium">browse files</button>
                </p>
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Max 5MB
                    </span>
                    <span>•</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                        JPG, PNG, PDF
                    </span>
                </div>
            `;
        }
        
        // Reset progress step
        const steps = document.querySelectorAll('#verification-modal .w-8.h-8');
        if (steps.length > 1) {
            steps[1].classList.remove('bg-blue-600', 'text-white');
            steps[1].classList.add('bg-gray-300', 'text-gray-600');
            
            const label = steps[1].nextElementSibling;
            if (label) {
                label.classList.remove('text-blue-600', 'font-medium');
                label.classList.add('text-gray-500');
            }
        }
    }
}

// Make function globally available
window.clearFileSelection = clearFileSelection;

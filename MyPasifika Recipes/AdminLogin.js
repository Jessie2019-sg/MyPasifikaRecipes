// AdminLogin.js
document.addEventListener('DOMContentLoaded', function() {
    const adminBtn = document.getElementById('adminBtn');
    const loginPopup = document.getElementById('loginPopup');
    const closeBtn = document.querySelector('.close-btn');

    // Show the popup
    adminBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action
        loginPopup.style.display = 'block';
    });

    // Close the popup
    closeBtn.addEventListener('click', function() {
        loginPopup.style.display = 'none';
    });

    // Close the popup if clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === loginPopup) {
            loginPopup.style.display = 'none';
        }
    });
});
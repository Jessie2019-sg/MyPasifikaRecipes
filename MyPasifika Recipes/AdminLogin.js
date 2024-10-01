// Get elements
const adminBtn = document.getElementById('adminBtn');
const popup = document.getElementById('loginPopup');
const closeBtn = document.querySelector('.close-btn');

// Show popup when admin button is clicked
adminBtn.addEventListener('click', () => {
    popup.style.display = 'block';
});

// Hide popup when close button is clicked
closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
});

// Hide popup if the user clicks outside the popup content
window.addEventListener('click', (event) => {
    if (event.target == popup) {
        popup.style.display = 'none';
    }
});

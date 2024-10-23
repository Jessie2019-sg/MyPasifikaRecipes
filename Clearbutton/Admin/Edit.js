// Get the modal element and buttons
const loginPopup = document.getElementById("loginPopup"); // Popup element
const editBtn = document.getElementById("editBtn");       // Button to open Edit Account popup
const closeBtn = document.querySelector('.close-btn');    // Close button inside the popup

// Show the Edit Account popup when the user clicks the Edit button
editBtn.onclick = function(event) {
    event.stopPropagation(); // Prevent the event from bubbling up
    loginPopup.style.display = "block"; // Show the popup
}

// Close the Edit Account popup when the user clicks the close button
closeBtn.onclick = function(event) {
    loginPopup.style.display = "none"; // Hide the popup
}

// Close the popup if clicking outside of it
window.onclick = function(event) {
    // Only close the popup if the click is outside the popup content
    if (event.target === loginPopup) {
        loginPopup.style.display = "none"; // Hide the popup
    }
}

// Prevent closing when clicking inside the popup content
document.querySelector('.popup-content').onclick = function(event) {
    event.stopPropagation(); // Prevent the click from closing the popup
}

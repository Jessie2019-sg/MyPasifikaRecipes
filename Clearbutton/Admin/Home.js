// Get the modal
const loginPopup = document.getElementById("loginPopup");

// Get the button that opens the modal
const adminBtn = document.getElementById("adminBtn");
const editBtn = document.getElementById("adminBtn");
// Get the <span> element that closes the modal
const closeBtn = document.getElementsByClassName("close-btn")[0];

// When the user clicks the button, open the modal 
adminBtn.onclick = function() {
    loginPopup.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function() {
    loginPopup.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === loginPopup) {
        loginPopup.style.display = "none";
    }
}
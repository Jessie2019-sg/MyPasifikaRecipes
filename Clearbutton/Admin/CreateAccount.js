// Get the modal elements and buttons for Create Account
const createAccountPopup = document.getElementById("createAccountPopup");
const createAccountBtn = document.getElementById("createBtn");
const closeCreateAccountBtn = document.getElementById("closeCreateAccount");

// Show the Create Account modal
createAccountBtn.onclick = function() {
    createAccountPopup.style.display = "block";
}

// Close the Create Account modal
closeCreateAccountBtn.onclick = function() {
    createAccountPopup.style.display = "none";
}

// Close the modal if clicking outside of it
window.onclick = function(event) {
    if (event.target === createAccountPopup) {
        createAccountPopup.style.display = "none";
    }
}



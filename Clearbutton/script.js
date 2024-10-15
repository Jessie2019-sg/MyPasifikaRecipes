document.getElementById('clearButton').addEventListener('click', function() {
    // Get the form element
    const form = document.getElementById('myForm');

    // Reset all form fields
    form.reset();

    // Clear any error or success messages
    document.getElementById('errorMessage').textContent = '';
    document.getElementById('successMessage').textContent = '';
});

document.getElementById('submitButton').addEventListener('click', function() {
    // Get the email and password input values
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Regular expression for validating email format
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Regular expression for validating password (at least 1 uppercase, 1 lowercase, 1 number, 1 special character)
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{12,}$/;

    // Check if the email is valid
    if (!emailPattern.test(email)) {
        document.getElementById('errorMessage').textContent = 'Please enter a valid email address.';
        return;
    }

    // Check if email length exceeds 255 characters
    if (email.length > 255) {
        document.getElementById('errorMessage').textContent = 'Email cannot be longer than 255 characters.';
        return;
    }

    // Check if the password meets the length requirement (minimum 12 characters)
    if (password.length < 12) {
        document.getElementById('errorMessage').textContent = 'Password must be at least 12 characters long.';
        return;
    }

    // Check if the password meets the pattern (uppercase, lowercase, number, special character)
    if (!passwordPattern.test(password)) {
        document.getElementById('errorMessage').textContent = 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
        return;
    }

    // Encourage the user to use 14 or more characters
    if (password.length < 14) {
        document.getElementById('successMessage').textContent = 'Password is valid, but consider using 14 or more characters for better security.';
    } else {
        document.getElementById('successMessage').textContent = 'Form submitted successfully!';
    }

    // Clear the error message if validation passes
    document.getElementById('errorMessage').textContent = '';
});

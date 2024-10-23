<?php
// UpdateAccount.php

// Database credentials
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password, if any
$dbname = "mypasifikarecipes"; // Your database name

// Connection to MyPasifikaRecipes
$recipes_conn = new mysqli($servername, $username, $password, $dbname);
if ($recipes_conn->connect_error) {
    die("Connection to MyPasifikaRecipes failed: " . $recipes_conn->connect_error);
}

session_start(); // Start a session to access session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted data
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Optional: Retrieve the current admin email from session
    if (!isset($_SESSION['A_email'])) {
        die("Admin Email not found in session.");
    }
    $adminEmail = $_SESSION['A_email']; // Assuming you store the admin email in session

    // Validate the email
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Check if the password and confirmation match
    if ($newPassword !== $confirmPassword) {
        die("Passwords do not match");
    }

    // Prepare the SQL query
    if (!empty($newPassword)) {
        // If password is being updated
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password
        $sql = "UPDATE admins SET A_email = ?, A_password = ? WHERE A_email = ?";
        $stmt = $recipes_conn->prepare($sql);
        $stmt->bind_param("sss", $newEmail, $hashedPassword, $adminEmail);
    } else {
        // If only email is being updated
        $sql = "UPDATE admins SET A_email = ? WHERE A_email = ?";
        $stmt = $recipes_conn->prepare($sql);
        $stmt->bind_param("ss", $newEmail, $adminEmail);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Account updated successfully";
        // Optionally, update the session email if changed
        $_SESSION['A_email'] = $newEmail; 
    } else {
        echo "Error updating account: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $recipes_conn->close();
} else {
    echo "Invalid request";
}

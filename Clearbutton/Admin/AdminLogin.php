<?php
session_start(); // Start the session

// Database connection settings
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbName = "mypasifikarecipes";

// Create a database connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbName);

// Set character set to avoid encoding issues
$conn->set_charset("utf8mb4");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("SELECT A_password FROM admins WHERE A_email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if an admin with the provided email exists
    if ($result->num_rows > 0) {
        // Fetch the hashed password from the database
        $row = $result->fetch_assoc();
        $hashed_password = $row['A_password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // If password is correct, log in the admin
            $_SESSION['A_email'] = $email; // Store admin email in session

            // Display a success message and redirect after a delay
            echo "<p style='color:green;'>Login successful. Redirecting to the admin dashboard...</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'Admin.php'; // Change to your actual admin page
                    }, 3000); // 3 seconds delay
                  </script>";
            exit();
        } else {
            // Incorrect password
            echo "<p style='color:red;'>Invalid password. Please try again.</p>";
        }
    } else {
        // Admin email not found
        echo "<p style='color:red;'>Invalid email. Please try again.</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

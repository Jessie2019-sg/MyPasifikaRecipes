<?php
session_start(); // Start the session

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbName = "mypasifikarecipes";

// Connect to database
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbName);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $password = $_POST['password'];

    // Query to verify admin credentials (using correct column names)
    $stmt = $mysqli->prepare("SELECT * FROM AdminLogin WHERE A_fname = ? AND A_lname = ?");
    $stmt->bind_param("ss", $fname, $lname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify if passwords match (replace with password_verify if using hashed passwords)
        if ($password == $user['A_password']) {
            // Set session variable for logged-in admin
            $_SESSION['admin_logged_in'] = true;

            // Redirect to the home page to display content and edit options
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Invalid first name or last name!";
    }

    $stmt->close();
}

$mysqli->close();
?>

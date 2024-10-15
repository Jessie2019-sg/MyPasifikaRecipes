<?php
// Database configuration
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbName = "mypasifikarecipes";

// Connect to the database
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbName);

// Check connection
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and validate it
    $name = $mysqli->real_escape_string(trim($_POST['name']));
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $message = $mysqli->real_escape_string(trim($_POST['message']));
    $rating = (int)$_POST['rating'];

    // Ensure the rating is between 1 and 5
    if ($rating < 1 || $rating > 5) {
        echo "<p style='color:red;'>Invalid rating. Please select a rating between 1 and 5.</p>";
    } else {
        // Prepare and execute the SQL statement
        $stmt = $mysqli->prepare("INSERT INTO reviews (Rev_message, Rev_rating) VALUES (?, ?)");
        $stmt->bind_param("si", $message, $rating); // "si" means string and integer

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Review submitted successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error submitting review: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$mysqli->close();


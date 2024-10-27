<?php
// Database connection
$servername = "localhost";
$username = "root";  // Adjust with your DB username
$password = "";      // Adjust with your DB password
$dbname = "mypasifikarecipes"; // Change to your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch uploaded files
$result = $conn->query("SELECT file_name, file_path FROM uploaded_files");

$uploaded_files = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $uploaded_files[] = $row;
    }
}
$conn->close();


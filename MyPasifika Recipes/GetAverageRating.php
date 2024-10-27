<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "mypasifikarecipes";  // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Fetch average rating
$sql_avg = "SELECT AVG(Rev_star_rating) as average_rating FROM reviews"; // Adjust the column name as necessary
$result_avg = $conn->query($sql_avg);

if ($result_avg->num_rows > 0) {
    $row_avg = $result_avg->fetch_assoc();
    echo json_encode(["success" => true, "average_rating" => round($row_avg['average_rating'], 2)]);
} else {
    echo json_encode(["success" => false, "message" => "No ratings found."]);
}

$conn->close();


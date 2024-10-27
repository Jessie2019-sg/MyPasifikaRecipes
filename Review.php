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

// If request method is POST (for submitting a review)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data from the request body
    $reviewData = json_decode(file_get_contents("php://input"), true);

    // Extract the review details
    $name = $reviewData['name'] ?? null;  // Use null coalescing to avoid notices
    $message = $reviewData['message'] ?? null;  // Use null coalescing
    $rating = isset($reviewData['rating']) ? $reviewData['rating'] : 0; // Default rating to 0 if not provided

    // Validate the data
    if (empty($name) || empty($message)) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit();
    }

    // Prepare the SQL statement to insert the review
    $sql = "INSERT INTO reviews (Rev_message, Rev_name, Rev_star_rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("ssi", $message, $name, $rating);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting review: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    }
    
// If request method is GET (for fetching reviews)
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Fetch latest reviews including the created date
    $sql = "SELECT Rev_name, Rev_message, Rev_created_at FROM reviews ORDER BY Rev_created_at DESC LIMIT 10";
    $result = $conn->query($sql);

    $reviews = [];
    if ($result->num_rows > 0) {
        // Store each review in the array
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        echo json_encode(["success" => true, "reviews" => $reviews]);
    } else {
        echo json_encode(["success" => false, "message" => "No reviews found."]);
    }
}

// Close the database connection
$conn->close();

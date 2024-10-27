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
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $mysqli->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Specify the directory where files will be uploaded
    $target_dir = "uploads/"; // Adjust the path as necessary

    // Check if uploads directory exists; if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["filename"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
        $file_name = $_FILES["filename"]["name"];
        $file_path = $target_file; // Full path where file is stored

        // Insert file details into the database
        $stmt = $mysqli->prepare("INSERT INTO dinner_upload (file_name, file_path) VALUES (?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ss", $file_name, $file_path);

            // Execute the statement
            if ($stmt->execute()) {
                // Return a JSON response with the uploaded file details
                echo json_encode([
                    'success' => true,
                    'file_name' => $file_name,
                    'file_path' => $file_path
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error saving file details to the database: ' . $stmt->error]);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Error preparing the SQL statement: ' . $mysqli->error]);
        }

    } else {
        echo json_encode(['success' => false, 'error' => 'Error uploading file.']);
    }
}

// Close the database connection
$mysqli->close();
?>

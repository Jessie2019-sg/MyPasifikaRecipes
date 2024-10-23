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
        echo "The file " . htmlspecialchars(basename($_FILES["filename"]["name"])) . " has been uploaded.";

        // Insert file details into the database
        $file_name = $_FILES["filename"]["name"];
        $file_path = $target_file; // Full path where file is stored

        // Prepare and bind using the correct variable
        $stmt = $mysqli->prepare("INSERT INTO dinner_upload (file_name, file_path) VALUES (?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ss", $file_name, $file_path);

            // Execute the statement
            if ($stmt->execute()) {
                echo "File details saved to the database successfully.";
                
                // Redirect back to admin page after 5 seconds
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'Admin.php'; // Change this to your admin page
                        }, 5000);
                      </script>";
            } else {
                echo "Error saving file details to the database: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the SQL statement: " . $mysqli->error;
        }

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Close the database connection
$mysqli->close();


<html>
<head>
    <title>Recipe Submission</title>
</head>
<body>

<?php
// Database connection parameters
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbName = "mypasifikarecipes";

// Connect to the database
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbName);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $R_title = $mysqli->real_escape_string($_POST['R_title']);
    $R_ingredients = $mysqli->real_escape_string($_POST['R_ingredients']);
    $R_instructions = $mysqli->real_escape_string($_POST['R_instructions']);
    $R_category = $mysqli->real_escape_string($_POST['R_Category']);  // Get recipe category

    // Handle image upload
    $R_image = NULL;  // Default is no image
    if (isset($_FILES['R_image']) && $_FILES['R_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['R_image']['name'];
        $image_tmp_name = $_FILES['R_image']['tmp_name'];
        $upload_dir = 'Uploads/';

        // Check if directory exists; if not, create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move the uploaded image to the uploads directory
        $image_path = $upload_dir . basename($image_name);
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $R_image = $image_path;  // Save the image path in the database
        } else {
            echo "Failed to upload image.";
        }
    }

    // Step 1: Check if the recipe title already exists
    $checkQuery = "SELECT * FROM recipesubmissions WHERE R_title = ?";
    $stmtCheck = $mysqli->prepare($checkQuery);
    $stmtCheck->bind_param("s", $R_title);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // Recipe with the same title already exists
        echo "<p style='color:red;'>Error: A recipe with the same title already exists.</p>";
    } else {
        // Step 2: Insert the recipe if it's not a duplicate
        $stmt = $mysqli->prepare("INSERT INTO recipesubmissions (R_Category, R_title, R_ingredients, R_instructions, R_image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $R_category, $R_title, $R_ingredients, $R_instructions, $R_image);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Recipe Submitted Successfully</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check statement and the connection
    $stmtCheck->close();
    $mysqli->close();
}
?>

</body>
</html>

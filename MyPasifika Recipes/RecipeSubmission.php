<html>
<head>
    <title>MyPasifika AdminLogin</title>
</head>
<body>

<?php
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = $mysqli->real_escape_string($_POST['title']);
    $ingredients = $mysqli->real_escape_string($_POST['ingredients']);
    $instructions = $mysqli->real_escape_string($_POST['instructions']);

    // Handle image upload
    $image = NULL;  // Default is no image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'Uploads/';
        

        // Move the uploaded image to the uploads directory
        $image_path = $upload_dir . basename($image_name);
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $image = $image_path;  // Save the image path in the database
        } else {
            echo "Failed to upload image.";
        }
    }

    // Insert data into the Submissions table
    $sql = "INSERT INTO recipesubmissions (title, ingredients, instructions, image) VALUES ('$title', '$ingredients', '$instructions', '$image')";

    if ($mysqli->query($sql) === TRUE) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
   

    $mysqli->close();
}
?>

</body>
</html>

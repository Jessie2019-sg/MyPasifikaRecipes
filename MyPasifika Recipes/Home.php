<?php
session_start(); // Start the session to check if admin is logged in

// Load the home page content
$content = file_get_contents('editHome.html'); // Store home content in a variable

// Append edit buttons if the admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Add the edit buttons for the admin
    $edit_buttons = "<a href='edit_home.php' class='edit-button'>Edit Home Page</a>";
    $edit_buttons .= "<a href='edit_recipes.php' class='edit-button'>Edit Recipes</a>";
    
    // Append the edit buttons to the content
    $content .= $edit_buttons;
}

// Display the content (with or without the edit buttons)
echo $content;
?>

<?php
session_start();

// Ensure only admins can access this page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "Access Denied!";
    exit();
}

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

// Fetch the current home page content from the database
$query = "SELECT * FROM Home.html"; // Assuming you store homepage content in this table
$result = $mysqli->query($query);

// Display current content
echo "<h1>Current Content</h1>";
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>Content ID: </strong>" . $row['id'] . "</p>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<a href='edit_home.php?delete=" . $row['id'] . "' class='delete-button'>Delete</a>";
}

// Close DB connection
$mysqli->close();
?>

<!-- Form to Add New Content -->
<h2>Add New Content</h2>
<form action="edit_home.php" method="POST">
    <textarea name="new_content" rows="4" cols="50" placeholder="Enter new content"></textarea>
    <button type="submit" name="add_content">Add Content</button>
</form>


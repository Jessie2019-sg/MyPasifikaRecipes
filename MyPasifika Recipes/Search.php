<?php
// search.php

// Connect to the MyPasifikaRecipes database using XAMPP's MySQL server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mypasifikarecipes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// search_site.php

// Get the search query from the form input
$query = $_GET['query'];

// Define an array of website files to search through
$files = ['Home.html', 'Recipes.html','Review.html', 'RecipeSubmission.html'];

// Initialize an array to hold the search results
$results = [];

// Loop through each file
foreach ($files as $file) {
    // Read the content of the file
    $content = file_get_contents($file);

    // Check if the search query exists in the content
    if (stripos($content, $query) !== false) {
        // If a match is found, add the file to the results array
        $results[] = $file;
    }
}

// Display the search results
if (count($results) > 0) {
    echo "<h2>Search Results for '$query'</h2>";
    echo "<ul>";
    foreach ($results as $result) {
        echo "<li><a href='$result'>" . ucfirst(basename($result, ".html")) . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "No results found for '$query'.";
}
?>
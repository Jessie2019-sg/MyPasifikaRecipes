<?php
// search.php

// Initialize an array to hold the search results
$results = [];

// Check if the query parameter is set
if (isset($_GET['query'])) {
    // Get the search query from the form input
    $query = trim($_GET['query']); // Trim to avoid leading/trailing spaces

    // Define an array of website files to search through
    $files = ['Home.html', 'Recipes.html', 'Review.html', 'RecipeSubmission.html'];

    // Loop through each file
    foreach ($files as $file) {
        if (file_exists($file)) {
            $content = file_get_contents($file);

            if (stripos($content, $query) !== false) {
                // Highlight the keyword in the result
                $highlightedContent = str_ireplace($query, '<span class="highlight">' . htmlspecialchars($query) . '</span>', $content);
                
                // Add the clean file name and a snippet to the results array
                $results[] = [
                    'file' => basename($file), // Show only the clean base filename
                    'snippet' => substr($highlightedContent, 0, 150) // Limit to 150 characters
                ];
            }
        }
    }

    // Return results as a dropdown list
    if (count($results) > 0) {
        echo '<ul>';
        foreach ($results as $result) {
            echo "<li><strong>" . htmlspecialchars($result['file']) . "</strong></li>";
        }
        echo '</ul>';
    } else {
        echo '<ul><li>No results found for "' . htmlspecialchars($query) . '".</li></ul>';
    }
}

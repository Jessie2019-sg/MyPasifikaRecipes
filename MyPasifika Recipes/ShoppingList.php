<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Replace with your username
$password = ""; // Replace with your password, if any
$dbname = ""; // Replace with your database name

// Connection to MyPasifikaRecipes
$recipes_conn = new mysqli('localhost', 'root', '', 'mypasifikarecipes');
if ($recipes_conn->connect_error) {
    die("Connection to mypasifikarecipes failed: " . $recipes_conn->connect_error);
}

// Connection to TrueMart
$truemart_conn = new mysqli('localhost', 'root', '', 'truemart');
if ($truemart_conn->connect_error) {
    die("Connection to truemart failed: " . $truemart_conn->connect_error);
}

// Query for ingredient_ids based on recipe_id from shopping_list in MyPasifikaRecipes
$recipe_id = 2; // Example recipe ID
$stmt = $recipes_conn->prepare("SELECT ingredient_id FROM shopping_list WHERE recipe_id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

$ingredient_ids = [];
while ($row = $result->fetch_assoc()) {
    $ingredient_ids[] = $row['ingredient_id'];
}

// Fetch corresponding ingredient details from TrueMart
if (!empty($ingredient_ids)) {
    // Use placeholders for SQL parameters
    $placeholders = implode(',', array_fill(0, count($ingredient_ids), '?'));
    
    // Prepare SQL statement
    $stmt = $truemart_conn->prepare("SELECT Ingredient_name, Quantity_available FROM ingredients WHERE Ingredient_id IN ($placeholders)");
    
    // Dynamically bind parameters based on the number of ingredient_ids
    $stmt->bind_param(str_repeat('i', count($ingredient_ids)), ...$ingredient_ids);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Display the results
    while ($row = $result->fetch_assoc()) {
        echo "Ingredient: " . $row['Ingredient_name'] . " - Available: " . $row['Quantity_available'] . "<br/>";
    }
} else {
    echo "No ingredients found for the selected recipe.";
}

// Close connections
$recipes_conn->close();
$truemart_conn->close();
// Function to fetch shopping list
function fetchShoppingList(recipe_id) {
    fetch(`getShoppingList.php?recipe_id=${recipe_id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Process the data and display it
            displayShoppingList(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

// Function to display the shopping list
function displayShoppingList(ingredients) {
    let shoppingListDiv = document.getElementById("shoppingList.php");
    shoppingListDiv.innerHTML = ""; // Clear previous entries
    ingredients.forEach(ingredient => {
        let item = document.createElement("div");
        item.textContent = `${ingredient.Ingredient_name}: ${ingredient.Quantity_available} available at $${ingredient.Unit_price}`;
        shoppingListDiv.appendChild(item);
    });
    shoppingListDiv.style.display = "block"; // Show the shopping list
}

// Add event listener to the "Shop for ingredients" button
document.addEventListener("DOMContentLoaded", function () {
    let shopButton = document.querySelector(".button.button2");
    shopButton.addEventListener("click", function () {
        // Assuming you have a way to get the recipe ID (e.g., as a data attribute)
        let recipe_id = 2; // Replace with the actual recipe ID relevant to Kava Muffins
        fetchShoppingList(recipe_id);
    });
});

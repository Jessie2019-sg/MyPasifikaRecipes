<?php
session_start(); // Start the session


// Welcome message
$admin_email = $_SESSION['A_email'];
?>

<!DOCTYPE html>
<div="en">
<head>
    <title>AdminPage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="AdminLogin.css">
    <link rel="stylesheet" href="RecipeSubmission.css">
</head>
<body>
    <!-- Header Section -->
<header>

<div class="container">
<nav>
<ul class="nav">
<img class = "imglogo" src="Images/Blue Elegant Initial B Butterfly Logo .png" alt="Search Icon">
<h1 class = "logo">My Pacifika Recipe</h1>
<li><a href="Home.html">Home</a></li>
<li><a href="Recipes.html">Recipes</a></li>
<li><a href="Review.html">Table Talk</a></li>
<li><a href="About.html">About</a></li>
<li><a href="FAQ.html">FAQ?</a></li>
<li><a href="#" class="search-icon" title="Search" onclick="openSearchPage()">
    <img src="Images/Search.png" alt="Search Icon">
</a>
</li>
<script>
// Function to open the search page with the query
function openSearchPage() {
const query = prompt("Enter a recipe to search for:");
if (query) {
// Redirect to search.html with the query as a URL parameter
window.location.href = `search.html?query=${encodeURIComponent(query)}`;
}
}
</script>
<li>
<button class = "image-button"  id="adminBtn"></button>
</li> <!-- Admin button -->
</ul>
</nav>  
</div>
</header>

<section>
<div class="column right" style = "float: right; margin-right: 5%;" >
<div class="form-container">
            <h2>Breakfast</h2>
            <ul id="breakfast-files">
                <?php 
                include 'BreakfastFetch.php'; // Fetch uploaded files from the database
                foreach ($uploaded_files as $file): ?>
                    <li>
                        <a href="<?php echo $file['file_path']; ?>" target="_blank">
                            <?php echo $file['file_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h2>Lunch</h2>
            <ul id="lunch-files">
                <?php 
                include 'LunchFetch.php'; 
                foreach ($uploaded_files as $file): ?>
                    <li>
                        <a href="<?php echo $file['file_path']; ?>" target="_blank">
                            <?php echo $file['file_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h2>Dinner</h2>
            <ul id="dinner-files">
                <?php 
                include 'DinnerFetch.php'; 
                foreach ($uploaded_files as $file): ?>
                    <li>
                        <a href="<?php echo $file['file_path']; ?>" target="_blank">
                            <?php echo $file['file_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
</div>
<div>
        <div class="column left" style = "float: left; margin-left: 5%; ">
        <div class="form-container">

            <h2>Submit Your Recipe</h2>
            <form id="recipeForm" action="RecipeSubmission.php" method="POST" enctype="multipart/form-data" onsubmit="showSuccessMessage(event)">
                
                <!-- Recipe Category -->
                <div class="form-group">
                    <label for="category">Recipe Category:</label>
                    <select id="category" name="R_Category" required>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Dinner">Dinner</option>
                    </select>
                </div>
    
                <!-- Recipe Title -->
                <div class="form-group">
                    <label for="title">Recipe Title:</label>
                    <input type="text" id="title" name="R_title" placeholder="Enter recipe title" required>
                </div>
    
                <!-- Ingredients -->
                <div class="form-group">
                    <label for="ingredients">Ingredients:</label>
                    <textarea id="ingredients" name="R_ingredients" placeholder="List the ingredients" required></textarea>
                </div>
        
                <!-- Instructions -->
                <div class="form-group">
                    <label for="instructions">Instructions:</label>
                    <textarea id="instructions" name="R_instructions" placeholder="Describe the preparation steps"></textarea>
                </div>
    
                <!-- Upload Image -->
                <div class="form-group">
                    <label for="image">Upload Image:</label>
                    <input type="file" id="image" name="R_image" accept="image/*">
                </div>
    
                <!-- Submit Button -->
                <div class="form-group">
                    <input type="submit" value="Submit Recipe">
                </div>
            </form>
        </div>
    </div>
  
    <!-- Success Message -->
    <div id="success-message" style="display: none;" class="success-container">
        <div class="success-icon">✔</div>
        <p>Recipe submitted successfully!</p>
    </div>
    </section>
    <script>
        // Function to display success message
        function showSuccessMessage(event) {
            event.preventDefault();
            document.getElementById('recipeForm').style.display = 'none';
            document.getElementById('success-message').style.display = 'block';
        }
    </script>

   <!-- Footer Section -->
<footer>
<div class="container">
<p> Contact Us Through </br>
Email: 
</p>
<p>&copy; 2024 My Pacifika Recipe. All rights reserved.</p>
<p><a href="https://www.facebook.com/profile.php?id=61566357703217" class="search-icon" title="Facebook">
<img src="Images/Facebook.png" alt="Facebook Icon">
</a></p>
<p><a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2F_u%2Fmypasifikarecipes%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR1VmYvhk6kI4EogYN5XJiYfYIuiu9TX8gvP2k4Ullr7nvRniOgDTZzRS3U_aem_3wAbpgBgyXXofN7rTfElww&h=AT2s1aPHkBWx91JxF92v6cuOFPSbIiByVq7jWSV0gVqK2S9zkFDPqiJofCyDt3re8HKCAmqybn8uq7HmsdJVQsXiVzC3TalTrvuXYhTL4atB3x_nPPRkeIGQET_l4fSgM4_YFA" class="search-icon" title="Instagram">
<img src="Images/instagram.png" alt="Instagram Icon">
</a></p>
</div>
</footer>



<!-- Move the script to the end of the body -->
<script src="search.js"></script>
<script src="AdminLogin.js"></script>
<script src="Home.js"></script>

</body>
</html>

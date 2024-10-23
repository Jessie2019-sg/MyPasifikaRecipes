<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['A_email'])) {
    // If not logged in, redirect to the login page
    header("Location: AdminLogin.php"); // Adjust to your login page
    exit();
}

// Welcome message
$admin_email = $_SESSION['A_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>AdminPage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="Admin.css">
    <link rel="stylesheet" href="AdminLogin.css">

</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            
            <nav>
                <ul class="nav">
                    <h1 class="logo">My Pacifika Recipe</h1>
                    <li><a href="Home.html">Home</a>
                        <div class="dropdown">
                            <a href="Admin.html" id="adminBtn">Admin Login</a> <!-- Admin button -->
                        </div>
                    </li>
                    <li><a href="Recipes.html">Recipes</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="Review.html">Review</a></li>
                    <li><a href="Home.html" id="logoutBtn"> Logout</a></li>
                <!-- Button to trigger the Edit Account popup -->
                <li><button id="editBtn">Edit Account</button></li>

<!-- Edit Account Information Popup -->
<div id="loginPopup" class="popup" style="display: none;"> <!-- Initially hidden -->
    <div class="popup-content">
        <span class="close-btn" style="cursor:pointer;">&times;</span>
        <h3>Edit Account Information</h3>
        <form action="UpdateAccount.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin_email); ?>" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">

            <div class="popup-buttons">
                <button type="submit">Update</button>
                <button type="button" id="discardBtn">Discard</button>
            </div>
        </form>
    </div>
</div>


<script src="Edit.js"></script>

<li><button id="createBtn">Create Account</button></li>
<div id="createAccountPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <h2 style="text-align:center">Create New Account</h2>
        <form action="CreateAccount.php" method="POST">
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Email" name="email" required>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <button type="submit" id="signUpBtn">Sign Up</button>
</form>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
                <p style="text-align:center"> By clicking "Sign Up", you are agreeing to our Terms, Privacy and Policy </p>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn" id="closeCreateAccount">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>
    </div>
</div>


<script src="CreateAccount.js"></script>

            
                <!-- Search Bar Section -->
        <div class="search-bar">
           <form action="Search.php" method="GET">
                <input type="text" placeholder="Search recipes..." name="query" required>
               <button type="submit">Search</button>
            </form>
        </div>
    </ul>
    </nav>
        </div>
    </header>

    <div class = "hero">
        <h1 class = "welcome-message" >Welcome, <?php echo htmlspecialchars($admin_email); ?>!</h1>
    </div>
  
    <div class="row">
    <div class="column">
        <h2>Breakfast</h2>
        <!-- Form for selecting and deleting files -->
        <form id="breakfast-form">
        <ul id="breakfast-files">
    <?php 
    include 'BreakfastFetch.php'; // Fetch uploaded files from the database
    foreach ($uploaded_files as $file): ?>
        <li id="file-<?php echo $file['file_name']; ?>"> <!-- Use file_name as the unique ID -->
            <input type="checkbox" class="link-checkbox" value="<?php echo $file['file_name']; ?>"> <!-- Use file_name for deletion -->
            <a href="<?php echo $file['file_path']; ?>" target="_blank">
                <?php echo $file['file_name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<button type="button" onclick="deleteSelectedLinks('Breakfast')">Delete Selected</button>
        </form>
        
        <p>Click on the "Choose File" button to upload a file:</p>
        <form id="uploadForm" action="BreakfastUpload.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="myFile" name="filename" required>
            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Repeat for Lunch -->
    <div class="column">
        <h2>Lunch</h2>
        <form id="lunch-form">
            <ul id="lunch-files">
                <?php 
                include 'LunchFetch.php'; 
                foreach ($uploaded_files as $file): ?>
                    <li id="file-<?php echo $file['file_name']; ?>">
                        <input type="checkbox" class="link-checkbox" name="selected_files[]" value="<?php echo $file['file_name']; ?>">
                        <a href="<?php echo $file['file_path']; ?>" target="_blank">
                            <?php echo $file['file_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="button" onclick="deleteSelectedLinks('Lunch')">Delete Selected</button>
        </form>
        
        <p>Click on the "Choose File" button to upload a file:</p>
        <form id="uploadForm" action="LunchUpload.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="myFile" name="filename" required>
            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Repeat for Dinner -->
    <div class="column">
        <h2>Dinner</h2>
        <form id="dinner-form">
            <ul id="dinner-files">
                <?php 
                include 'DinnerFetch.php'; 
                foreach ($uploaded_files as $file): ?>
                    <li id="file-<?php echo $file['id']; ?>">
                        <input type="checkbox" class="link-checkbox" name="selected_files[]" value="<?php echo $file['id']; ?>">
                        <a href="<?php echo $file['file_path']; ?>" target="_blank">
                            <?php echo $file['file_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="button" onclick="deleteSelectedLinks('Dinner')">Delete Selected</button>
        </form>
        
        <p>Click on the "Choose File" button to upload a file:</p>
        <form id="uploadForm" action="DinnerUpload.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="myFile" name="filename" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</div>
<div>
<script src="Delete.js"></script> <!-- Include your JS file -->
 </div>
 <footer>
        <div class="container">
            <p>&copy; 2024 My Pacifika Recipe. All rights reserved.</p>
            <p><a href="https://www.facebook.com/profile.php?id=61566357703217"></a>Facebook</p>
            <p><a href=""></a>Instagram</p>
            <p><a href=""></a>Twitter</p>
        </div>
    </footer>
    
    <script src="Admin.js"></script>
</body>
</html>

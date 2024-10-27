// Get modal elements
const modal = document.getElementById("ratingModal");
const closeModal = document.getElementsByClassName("close")[0];
const submitPopupRating = document.getElementById("submitPopupRating");

// Variables to store total rating and number of ratings
let totalRating = 0;
let numberOfRatings = 0;

// Button to open modal
const rateButton = document.querySelector(".Rate-button");

// Event to open modal when "Rate" button is clicked
rateButton.addEventListener("click", function() {
    clearModalInputs();
    modal.style.display = "block";
});

// Handle pop-up rating submission
submitPopupRating.addEventListener("click", function () {
    const selectedRating = document.querySelector('input[name="popup-rating"]:checked');
    const userName = document.getElementById("popup-name").value;  // Get the user's name from the modal

    if (selectedRating && userName) {
        const ratingValue = parseInt(selectedRating.value);
        
        // Update total rating and number of ratings
        totalRating += ratingValue;
        numberOfRatings += 1;
        
        // Calculate the average rating
        const averageRating = (totalRating / numberOfRatings).toFixed(1);
        
        // Update the average rating on the page with stars
        document.getElementById("averageRating").innerHTML = createStarRating(averageRating);

        // Add the name and rating to the rating list
        const reviewList = document.querySelector('.rating-list'); // Reference to the review list
        const reviewDiv = document.createElement('div');
        reviewDiv.classList.add('rating');

        // Create a paragraph for the name
        const nameParagraph = document.createElement('p');
        nameParagraph.classList.add('review-name');
        nameParagraph.textContent = userName;
        
        // Create a paragraph for the rating (stars)
        const ratingParagraph = document.createElement('p');
        ratingParagraph.classList.add('review-rating');
        ratingParagraph.innerHTML = createStarRating(ratingValue); // Use function for stars

        // Append name and rating to the review div
        reviewDiv.appendChild(nameParagraph);
        reviewDiv.appendChild(ratingParagraph);

        // Append the review div to the review list
        reviewList.appendChild(reviewDiv);

        // Save the rating to localStorage
        saveRatingToLocalStorage(userName, ratingValue);

        // Thank the user for their rating
        alert("Thank you for your rating!");

        // Close the modal after submission
        modal.style.display = "none";

        // Optional: Send the rating data to the server
        fetch("Rating.php", {
            method: "POST",
            body: JSON.stringify({
                rating: ratingValue,
                name: userName
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error(data.message);
            }
        })
        .catch(error => console.error("Error submitting rating:", error));
    } else {
        alert("Please select a rating and enter your name before submitting.");
    }
});

// Function to create star rating HTML
function createStarRating(rating) {
    let stars = '';
    const ratingValue = Math.round(rating); // Round the rating value for stars
    for (let i = 0; i < ratingValue; i++) {
        stars += '<span class="filled-star">&#9733;</span>'; // Filled star
    }
    for (let i = ratingValue; i < 5; i++) {
        stars += '<span class="empty-star">&#9734;</span>'; // Empty star
    }
    return stars;
}

// Close the modal when the user clicks on (x)
closeModal.onclick = function() {
    modal.style.display = "none";
}

// Close the modal if the user clicks anywhere outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Function to save rating to localStorage
function saveRatingToLocalStorage(name, rating) {
    const ratings = JSON.parse(localStorage.getItem('ratings')) || [];
    ratings.push({ name, rating });
    localStorage.setItem('ratings', JSON.stringify(ratings));
}

// Function to fetch and display ratings from localStorage
function fetchReviews() {
    const ratings = JSON.parse(localStorage.getItem('ratings')) || [];
    ratings.forEach(({ name, rating }) => {
        const reviewList = document.querySelector('.rating-list');
        const reviewDiv = document.createElement('div');
        reviewDiv.classList.add('rating');

        const nameParagraph = document.createElement('p');
        nameParagraph.classList.add('review-name');
        nameParagraph.textContent = name;

        const ratingParagraph = document.createElement('p');
        ratingParagraph.classList.add('review-rating');
        ratingParagraph.innerHTML = createStarRating(rating); // Use function for stars

        reviewDiv.appendChild(nameParagraph);
        reviewDiv.appendChild(ratingParagraph);
        reviewList.appendChild(reviewDiv);
    });

    // Calculate and display the average rating
    const totalRatings = ratings.reduce((sum, { rating }) => sum + rating, 0);
    const averageRating = (totalRatings / ratings.length).toFixed(1) || 0;
    document.getElementById("averageRating").innerHTML = createStarRating(averageRating); // Display stars for average rating
}

// Function to clear modal inputs
function clearModalInputs() {
    // Clear selected rating
    const ratingInputs = document.querySelectorAll('input[name="popup-rating"]');
    ratingInputs.forEach(input => input.checked = false);

    // Clear user name
    document.getElementById("popup-name").value = '';
}

// Fetch reviews when the page loads
document.addEventListener("DOMContentLoaded", fetchReviews);

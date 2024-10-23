// Function to display reviews and ratings from localStorage
function displayReviews() {
    const reviews = JSON.parse(localStorage.getItem('reviews')) || []; // Get reviews from localStorage
    const reviewsContainer = document.getElementById('reviews');
    const ratingsContainer = document.getElementById('ratings');

    // Clear the containers
    reviewsContainer.innerHTML = '';
    ratingsContainer.innerHTML = '';

    // Check if there are any reviews
    if (reviews.length === 0) {
        reviewsContainer.innerHTML = '<p>No reviews submitted yet.</p>';
        ratingsContainer.innerHTML = '<p>No ratings yet.</p>';
        return;
    }

    // Create HTML for each review and corresponding rating
    reviews.forEach(review => {
        // Create the review element for the left column
        const reviewElement = document.createElement('div');
        reviewElement.classList.add('review-box');
        reviewElement.innerHTML = `<p>${review.message}</p>`;
        reviewsContainer.appendChild(reviewElement);

        // Create the star rating element for the right column
        const ratingElement = document.createElement('div');
        ratingElement.classList.add('rating-box');
        ratingElement.innerHTML = `<p>${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</p>`;
        ratingsContainer.appendChild(ratingElement);
    });
}

// Call the displayReviews function when the page loads
window.onload = displayReviews;

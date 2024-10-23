// Handle form submission and show the pop-up after submission
document.getElementById('reviewForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting the default way

    const name = document.getElementById('name').value;
    const message = document.getElementById('message').value;
    const rating = document.querySelector('input[name="rating"]:checked').value;

    // Get existing reviews from localStorage or initialize an empty array
    const reviews = JSON.parse(localStorage.getItem('reviews')) || [];

    // Add the new review to the reviews array
    reviews.push({ name, message, rating });

    // Save the updated reviews array to localStorage
    localStorage.setItem('reviews', JSON.stringify(reviews));

    // Show the pop-up message
    alert('Thank you for your feedback! Click "OK" to view your review and rating.');

    // Redirect to the view review page after submission
    window.location.href = 'viewReview.html';
});

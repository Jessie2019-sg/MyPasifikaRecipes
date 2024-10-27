document.addEventListener("DOMContentLoaded", function () {
    const reviewForm = document.getElementById("reviewForm");
    const submitPopupRating = document.getElementById("submitPopupRating");

    // Handle form submission
    reviewForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object from the form
        const formData = new FormData(reviewForm);

        // Send the review data to the server without star rating
        fetch("Review.php", {
            method: "POST",
            body: JSON.stringify({
                name: formData.get("name"),
                message: formData.get("message"),
                // Exclude star rating from the form submission
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the form inputs
                reviewForm.reset();

                // Show success message
                document.getElementById("successMessage").style.display = "block";

                // Fetch the latest reviews to update the display
                fetchLatestReviews();
            } else {
                console.error(data.message);
            }
        })
        .catch(error => console.error("Error submitting review:", error));
    });

   
    // Function to fetch and display latest reviews
    function fetchLatestReviews() {
        fetch("Review.php") // Adjust the path as necessary
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const reviewsContainer = document.querySelector(".review-list");
                    reviewsContainer.innerHTML = ""; // Clear existing reviews

                    data.reviews.forEach(review => {
                        const reviewDiv = document.createElement("div");
                        reviewDiv.classList.add("review");

                        // Create and append name
                        const nameElement = document.createElement("p");
                        nameElement.classList.add("review-name");
                        nameElement.textContent = review.Rev_name;

                        // Create and append message
                        const messageElement = document.createElement("p");
                        messageElement.classList.add("review-message");
                        messageElement.textContent = review.Rev_message;

                        // Create and append created date
                        const dateElement = document.createElement("p");
                        dateElement.classList.add("review-date");
                        const date = new Date(review.Rev_created_at); // Convert to JavaScript Date
                        dateElement.textContent = date.toLocaleDateString(); // Format the date

                        // Append elements to review div
                        reviewDiv.appendChild(nameElement);
                        reviewDiv.appendChild(messageElement);
                        reviewDiv.appendChild(dateElement);

                        // Append review div to the reviews container
                        reviewsContainer.appendChild(reviewDiv);
                    });
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error("Error fetching reviews:", error));
    }

    // Fetch the latest reviews on page load
    fetchLatestReviews();
});

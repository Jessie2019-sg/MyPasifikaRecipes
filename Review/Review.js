document.addEventListener("DOMContentLoaded", function () {
    const reviewForm = document.getElementById("reviewForm");
    const submitPopupRating = document.getElementById("submitPopupRating");

    // Handle form submission
    reviewForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object from the form
        const formData = new FormData(reviewForm);
        const name = formData.get("name");
        const message = formData.get("message");

        // Debugging: Log the values of name and message
        console.log("Name:", name);
        console.log("Message:", message);

        // Validation checks
        if (!name || name.length > 25) {
            alert("Name must be 25 characters or less.");
            return; // Stop submission
        }

        if (!message || message.length > 300) {
            alert("Message must be 300 characters or less.");
            return; // Stop submission
        }

        // Send the review data to the server without star rating
        fetch("Review.php", {
            method: "POST",
            body: JSON.stringify({
                name: name,
                message: message,
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

                function handleSubmit(event) {
                    event.preventDefault(); // Prevent the form from submitting normally
            
                    // Simulate form submission success or error
                    const isSuccess = Math.random() > 0.5; // Randomly decide if submission is successful or not
            
                    if (isSuccess) {
                        showMessage('successMessage');
                    } else {
                        showMessage('errorMessage');
                    }
            
                    // Reset the form (optional)
                    document.getElementById('reviewForm').reset();
                }
            
                function showMessage(messageId) {
                    const messageElement = document.getElementById(messageId);
                    messageElement.style.display = 'block'; // Show the message
            
                    // Hide the message after 5 seconds
                    setTimeout(() => {
                        messageElement.style.display = 'none';
                    }, 5000);
                }
           

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

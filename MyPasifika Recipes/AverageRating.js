document.getElementById("submitRating").addEventListener("click", function () {
    const rating = document.querySelector('input[name="recipeRating"]:checked');

    if (rating) {
        const ratingValue = rating.value;

        // Send rating to the server
        fetch("SubmitRating.php", { // Path to your PHP script
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ rating: ratingValue }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("ratingMessage").textContent = "Thank you for your rating!";
                    document.getElementById("ratingMessage").style.display = "block";
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error("Error submitting rating:", error));
    } else {
        alert("Please select a rating.");
    }
});

// Fetch average rating
document.getElementById("fetchAverageRating").addEventListener("click", function () {
    fetch("GetAverageRating.php") // New PHP file to get average rating
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("averageRating").textContent = "Average Rating: " + data.average_rating + " stars";
            } else {
                document.getElementById("averageRating").textContent = "Error fetching average rating.";
                console.error(data.message);
            }
        })
        .catch(error => console.error("Error fetching average rating:", error));
});

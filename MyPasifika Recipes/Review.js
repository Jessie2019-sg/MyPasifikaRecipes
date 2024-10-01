document.querySelectorAll('.rating input').forEach(input => {
    input.addEventListener('change', (event) => {
        const rating = event.target.value;
        alert(`You selected ${rating} star(s)`);
        // send the rating to a server or handle it as needed
        // Example: sendRatingToServer(rating);
    });
});

// sending the rating to a server
function sendRatingToServer(rating) {
    fetch('/submit-rating', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ rating: rating }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
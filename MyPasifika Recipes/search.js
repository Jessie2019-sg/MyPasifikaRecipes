
// Attach an event listener to the search form
document.querySelector('.search-bar form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get the search query
    const query = event.target.querySelector('input[name="query"]').value.toLowerCase();

    // Select all thumbnails
    const thumbnails = document.querySelectorAll('.thumbnail');

    // Loop through thumbnails and show/hide based on the query
    thumbnails.forEach(thumbnail => {
        const keywords = thumbnail.getAttribute('data-keywords').toLowerCase();
        if (keywords.includes(query)) {
            thumbnail.style.display = 'block'; // Show matching thumbnails
        } else {
            thumbnail.style.display = 'none'; // Hide non-matching thumbnails
        }
    });
});


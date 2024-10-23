// Function to delete selected links for the chosen category (Breakfast, Lunch, or Dinner)
function deleteSelectedLinks(category) {
    // Get all checkboxes for the specific category
    const checkboxes = document.querySelectorAll(`#${category.toLowerCase()}-files .link-checkbox`);
    const selectedFileNames = [];

    // Collect selected file names
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedFileNames.push(checkbox.value);  // Push the file_name to the array
        }
    });

    if (selectedFileNames.length === 0) {
        alert('No files selected for deletion.');
        return;  // Exit if no files are selected
    }

    // Send AJAX request to delete selected files from the backend
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `Delete${category}.php`, true); // Dynamically select the correct PHP file
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Prepare the data to send (array of file names)
    const data = `selected_files[]=${selectedFileNames.join('&selected_files[]=')}`;

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                // Remove the selected links from the DOM immediately
                selectedFileNames.forEach(fileName => {
                    const linkElement = document.getElementById(`file-${fileName}`);
                    if (linkElement) {
                        linkElement.remove();  // Remove the selected link from DOM
                    }
                });
                alert('Selected links deleted successfully!');
            } else {
                alert('Error: ' + response.message);
            }
        } else {
            alert('Failed to communicate with the server.');
        }
    };

    // Send the request with the selected file names
    xhr.send(data);
}

// Load existing uploaded files when the page loads
window.onload = function() {
    fetch('fetch_files.php')
        .then(response => response.json())
        .then(files => {
            const ul = document.getElementById('breakfast-files');
            ul.innerHTML = ''; // Clear the list first

            files.forEach(file => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.textContent = file.file_name;
                a.href = file.file_path;
                a.target = '_blank'; // Open the file in a new tab
                li.appendChild(a);
                ul.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching files:', error));
};

// Handle the form submission for uploading a new file
document.getElementById("uploadForm").onsubmit = function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Create a new list item for the uploaded file
            const ul = document.getElementById("breakfast-files");
            const newListItem = document.createElement("li");
            const newLink = document.createElement("a");
            newLink.href = data.file_path;
            newLink.textContent = data.file_name;
            newLink.target = "_blank";
            newListItem.appendChild(newLink);

            // Append to the existing list
            ul.appendChild(newListItem);

            // Optionally clear the file input
            document.getElementById("myFile").value = "";
        } else {
            alert("File upload failed: " + data.error);
        }
    })
    .catch(error => console.error("Error during file upload:", error));
};

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

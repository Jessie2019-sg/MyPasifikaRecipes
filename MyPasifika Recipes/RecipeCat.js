function scrollLeft(containerId) {
    const container = document.getElementById(containerId).parentElement;
    container.scrollBy({ top: 0, left: -250, behavior: 'smooth' });
}

function scrollRight(containerId) {
    const container = document.getElementById(containerId).parentElement;
    container.scrollBy({ top: 0, left: 250, behavior: 'smooth' });
}

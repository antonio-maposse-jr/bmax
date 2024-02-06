function removeFile(inputId, displayId, containerID) {
    var fileInput = document.getElementById(inputId);
    var fileDisplay = document.getElementById(displayId);
    var fileContainer = document.getElementById(containerID);

    // Reset file input
    fileInput.value = '';

    // Hide file display section and show file input
    fileDisplay.style.display = 'none';
    fileContainer.style.display = 'block'
}
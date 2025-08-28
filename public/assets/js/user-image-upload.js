function displayImage(event) {
    const imageContainer = document.getElementById('imageContainer');
    const closeIcon = document.getElementById('closeIcon');
    const uploadedImage = document.getElementById('uploadedImage');

    // Hide the close icon when a new image is uploaded
    closeIcon.style.display = 'none';

    // Check if an image is uploaded
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Set the uploaded image as the source for the image element
            uploadedImage.src = e.target.result;
            // Show the close icon since an image is displayed
            closeIcon.style.display = 'block';
            uploadedImage.style.display = 'block';
        };

        // Read the uploaded file as a data URL
        reader.readAsDataURL(event.target.files[0]);
    } else {
        // If no image is uploaded, clear the image source
        uploadedImage.src = '';
    }
}

function removeImage() {
    const imageInput = document.getElementById('imageInput');
    const imageContainer = document.getElementById('imageContainer');
    const uploadedImage = document.getElementById('uploadedImage');
    const closeIcon = document.getElementById('closeIcon');

    // Clear the input path
    imageInput.value = '';
    // Remove the uploaded image
    uploadedImage.src = '';
    // Hide the close icon again
    closeIcon.style.display = 'none';
    uploadedImage.style.display = 'none';
}
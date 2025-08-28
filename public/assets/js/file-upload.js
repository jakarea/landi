   // Get the required elements
   const uploadLabel = document.getElementById('upload-label');
   const icon = document.getElementById('icon');
   const imageInput = document.getElementById('image-input');
   const uploadedImage = document.getElementById('uploaded-image');
   const uploadedImagePreview = document.getElementById('uploaded-image-preview');
   const uploadedImageName = document.getElementById('uploaded-image-name');
   const closeIcon = document.getElementById('close-icon');
   const staticImage = document.querySelector('.static-image');
   
   // Add event listener to the image input
   imageInput.addEventListener('change', handleImageUpload);
   
   // Function to handle image upload
   function handleImageUpload() {
     const file = this.files[0];
   
     // Check if a file was selected
     if (file) {
       const reader = new FileReader();
       
       // Set the image source and name once it's loaded
       reader.onload = function(e) {
         uploadedImagePreview.src = e.target.result;
         uploadedImageName.textContent = file.name;
         showUploadedImage();
       }
       
       // Read the image file as a data URL
       reader.readAsDataURL(file);
     }
   }
   
   // Function to show the uploaded image and name
   function showUploadedImage() {
     staticImage.style.display = 'none';
     uploadedImage.style.display = 'block';
     icon.classList.remove('fa-plus');
     icon.classList.add('fa-times');
   }
   
   // Function to hide the uploaded image and reset the input
   function hideUploadedImage() {
     staticImage.style.display = 'block';
     uploadedImage.style.display = 'none';
     uploadedImageName.textContent = '';
     imageInput.value = '';
     icon.classList.remove('fa-times');
     icon.classList.add('fa-plus');
   }
   
   // Add event listener to the close icon
   closeIcon.addEventListener('click', hideUploadedImage);
   
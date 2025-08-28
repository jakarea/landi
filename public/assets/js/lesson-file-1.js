 // Setup for the first input
 const thumbnailInput1 = document.getElementById('thumbnail');
 const thumbnailImage1 = document.querySelector('.media img');
 const uploadedImage1 = document.getElementById('uploadedImg');
 const removeImageBtn1 = document.getElementById('removeImage');
 
 // Function to handle file selection for the first input
 thumbnailInput1.addEventListener('change', (event) => {
     const selectedFile = event.target.files[0];
 
     if (selectedFile) {
         const reader = new FileReader();
 
         reader.onload = (e) => {
             thumbnailImage1.classList.add('d-none');
             uploadedImage1.src = e.target.result;
             uploadedImage1.parentElement.style.display = 'block';
         };
 
         reader.readAsDataURL(selectedFile);
     }
 });
 
 // Function to handle image removal for the first input
 removeImageBtn1.addEventListener('click', () => {
     uploadedImage1.src = '{{asset("assets/images/placeholder.svg")}}';
     thumbnailInput1.value = ''; // Clear the file input
     uploadedImage1.parentElement.style.display = 'none';
     thumbnailImage1.classList.remove('d-none');
 });

 

// Setup for the second input
const thumbnailInput2 = document.getElementById('lesson_file');
const thumbnailImage2 = document.querySelector('.media2 img');
const uploadedImage2 = document.getElementById('uploadedImg2');
const removeImageBtn2 = document.getElementById('removeImage2');

// Function to handle file selection for the second input
thumbnailInput2.addEventListener('change', (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        const reader = new FileReader();

        reader.onload = (e) => {
            thumbnailImage2.classList.add('d-none');
            uploadedImage2.src = e.target.result;
            uploadedImage2.parentElement.style.display = 'block';
        };

        reader.readAsDataURL(selectedFile);
    }
});

// Function to handle image removal for the second input
removeImageBtn2.addEventListener('click', () => {
    uploadedImage2.src = '{{asset("assets/images/placeholder.svg")}}';
    thumbnailInput2.value = ''; // Clear the file input
    uploadedImage2.parentElement.style.display = 'none';
    thumbnailImage2.classList.remove('d-none');
});
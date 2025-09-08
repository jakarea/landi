$(document).ready(function() {
    console.log('Banner crop script starting');
    console.log('jQuery available:', typeof $);
    console.log('Bootstrap available:', typeof bootstrap);
    console.log('Croppie available:', typeof $.fn.croppie);
    
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

    function readFile(input) {
        console.log('readFile called with input:', input);
        if (input.files && input.files[0]) {
            console.log('File found:', input.files[0]);
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log('FileReader onload triggered');
                rawImg = e.target.result;
                console.log('Image data loaded, length:', rawImg.length);
                
                // Initialize croppie with the image immediately
                if ($uploadCrop) {
                    $uploadCrop.croppie('bind', {
                        url: rawImg
                    }).then(function () {
                        console.log('Croppie bound successfully');
                    });
                }
                
                console.log('About to show modal');
                var modalElement = document.getElementById('cropImagePop');
                console.log('Modal element:', modalElement);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                    console.log('Modal show called');
                } else {
                    console.error('Modal element not found!');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            console.log("Sorry - your browser doesn't support the FileReader API");
        }
    }

    console.log('Initializing croppie on element:', $('#upload-demo'));
    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 400,
            height: 150,
        },
        enforceBoundary: false,
        enableExif: true
    });
    console.log('Croppie initialized:', $uploadCrop);

    document.getElementById('cropImagePop').addEventListener('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log('Croppie bind complete');
        });
    });

    $('.item-img').on('change', function () {
        console.log('jQuery file input changed event triggered');
        console.log('This element:', this);
        console.log('Files:', this.files);
        imageId = $(this).data('id'); 
        tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); 
        readFile(this);
    });

    $('#cancelCropBtn').on('click', function (e) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('cropImagePop'));
        modal.hide();
    });

    $('#cropImageBtn').on('click', function (ev) {
        console.log('Crop button clicked');
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpg',
            size: { width: 1680, height: 435 }
        }).then(function (resp) {
            console.log('Croppie result generated, length:', resp.length);
            
            // Update the cover photo preview
            $('#item-img-output').attr('src', resp);
            $('#item-img-output').removeClass('hidden');
            $('#cover-placeholder').addClass('hidden');
            $('#coverImgBase64').attr('value', resp);
            
            console.log('Image preview updated');
            
            // Show save/cancel buttons
            $('#uploadBtn').removeClass('hidden').show();
            $('#cancelBtn').removeClass('hidden').show();
            
            console.log('Save/Cancel buttons shown');
            
            // Hide modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('cropImagePop'));
            if (modal) {
                modal.hide();
                console.log('Modal hidden');
            }
        }).catch(function(err) {
            console.error('Croppie result error:', err);
        });
    });
}); 
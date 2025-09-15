$(document).ready(function() {
    
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                rawImg = e.target.result;
                
                // Initialize croppie with the image immediately
                if ($uploadCrop) {
                    $uploadCrop.croppie('bind', {
                        url: rawImg
                    }).then(function () {
                    });
                }
                
                var modalElement = document.getElementById('cropImagePop');
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } else {
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 400,
            height: 150,
        },
        enforceBoundary: false,
        enableExif: true
    });

    document.getElementById('cropImagePop').addEventListener('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
        });
    });

    $('.item-img').on('change', function () {
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
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpg',
            size: { width: 1680, height: 435 }
        }).then(function (resp) {
            
            // Update the cover photo preview
            $('#item-img-output').attr('src', resp);
            $('#item-img-output').removeClass('hidden');
            $('#cover-placeholder').addClass('hidden');
            $('#coverImgBase64').attr('value', resp);
            
            
            // Show save/cancel buttons
            $('#uploadBtn').removeClass('hidden').show();
            $('#cancelBtn').removeClass('hidden').show();
            
            
            // Hide modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('cropImagePop'));
            if (modal) {
                modal.hide();
            }
        }).catch(function(err) {
        });
    });
}); 
var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
    else {
        swal("Sorry - you're browser doesn't support the FileReader API");
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
$('#cropImagePop').on('shown.bs.modal', function () {
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function () {
        // console.log('jQuery bind complete');
    });
});

$('.item-img').on('change', function () {
    imageId = $(this).data('id'); tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId); readFile(this);
});
$('#cancelCropBtn').on('click', function (e) {
    $('#cropImagePop').modal('hide');
});
$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpg',
        size: { width: 1680, height: 435 }
    }).then(function (resp) {
        $('#item-img-output').attr('src', resp);
        $('#coverImgBase64').attr('value', resp);
        $('#uploadBtn').removeClass('d-none');
        $('#cancelBtn').removeClass('d-none');
        $('#cropImagePop').modal('hide');
    });
}); 
@extends('layouts/instructor')
@section('title') Bundle Course Create Page @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/css/product-researchs.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/common.css') }}" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    rel="stylesheet" type="text/css">

@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<!-- === course create page @S === -->
<main class="product-research-form">
    <div class="product-research-create-wrap">
        <div class="row">
            <div class="col-lg-12">
                <div class="create-form-wrap">
                    <div class="create-form-head">
                        <h6>Upload video file</h6>
                    </div>
                    <!-- <div id="progressBar" style="width: 0%;"></div> -->
                    <div class="progress">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- course create form @S -->
                    <form  id="uploadForm" action="/instructor/lessons/upload-vimeo-submit" method="POST" class="create-form-box custom-select" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="file-upload-4">video <sup class="text-danger">*</sup></label>
                                            <input type="file" name="video" id="file-upload-8">
                                        
                                        </div> 
                                    </div> 
                                
                                </div> <!-- row end -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="submit-bttns">
                                    <button type="reset" class="btn btn-reset">Clear</button>
                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>



                    <!-- course create form @E -->
                </div>
            </div>
        </div>
    </div>
</main>
<!-- === course create page @E === -->
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="{{asset('assets/js/file-upload.js')}}" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
    type="text/javascript"></script>

    <script>
    $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    var uri = response.uri;
                    checkProgress(uri);
                }
            });
        });

        function checkProgress(uri) {
            var interval = setInterval(function() {
                $.ajax({
                    url: '/instructor/lessons/progress',
                    type: 'GET',
                    data: { uri: uri },
                    dataType: 'json',
                    success: function(response) {
                        var progress = response.progress;
                        $('#progressBar').css('width', progress + '%');

                        if (progress === 100) {
                            clearInterval(interval);
                        }
                    }
                });
            }, 1000);
        }
    });
</script>
@endsection

{{-- page script @E --}}
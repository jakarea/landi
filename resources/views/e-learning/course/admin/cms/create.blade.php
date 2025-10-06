@extends('layouts.latest.admin')

@section('title')
    Add New CMS Content
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add New CMS Content</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cms.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="key">Key</label>
                                <input type="text" class="form-control" id="key" name="key" placeholder="Enter key">
                            </div>
                            <div class="form-group">
                                <label for="value">Value</label>
                                <textarea class="form-control" id="value" name="value" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

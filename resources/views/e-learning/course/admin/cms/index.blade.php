@extends('layouts.latest.admin')

@section('title')
    CMS Management
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">CMS Management</h5>
                            <a href="{{ route('cms.create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cms as $item)
                                    <tr>
                                        <td>{{ $item->key }}</td>
                                        <td>{{ $item->value }}</td>
                                        <td>
                                            <a href="{{ route('cms.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('cms.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

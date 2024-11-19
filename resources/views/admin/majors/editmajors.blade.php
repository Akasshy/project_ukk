
@extends('template.template')
@section('content')
<div class="main m-4">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Majors Management</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="">Edit Major</a>
            </li>
        </ul>
    </div>
    <div class="card bg-white p-5">
        <form action="/majors/{{$major->id}}/update" method="post">
            @csrf
            @method('PUT')
            <h4 class="text-primary fw-bold">Edit Major</h4>
            <div class="mb-3">
                <label for="major_name" class="form-label">Major Name</label>
                <input type="text" class="form-control" id="major_name" name="major_name"
                       value="{{ old('major_name', $major->major_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"
                          placeholder="Enter description">{{ old('description', $major->description) }}</textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Update">
            <a href="/majors" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection

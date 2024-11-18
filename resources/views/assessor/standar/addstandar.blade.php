@extends('template.templateassessor')
@section('content')
<div class="main m-4">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="/competency-standard">Competency Standards</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="">Add New</a></li>
        </ul>
    </div>
    <div class="card bg-white p-5">
        <form action="/addst" method="post">
            @csrf
            <h4 class="text-primary fw-bold">Add Competency Standard</h4>
            <div class="mb-3">
                <label for="unit_code" class="form-label">Unit Code</label>
                <input type="text" class="form-control" id="unit_code" name="unit_code" required>
            </div>
            <div class="mb-3">
                <label for="unit_title" class="form-label">Unit Title</label>
                <input type="text" class="form-control" id="unit_title" name="unit_title" required>
            </div>
            <div class="mb-3">
                <label for="unit_description" class="form-label">Unit Description</label>
                <textarea class="form-control" id="unit_description" name="unit_description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="major_id" class="form-label">Major</label>
                <select class="form-select" id="major_id" name="major_id" required>
                    <option value="" disabled selected>-- Select Major --</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->major_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/standar" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection

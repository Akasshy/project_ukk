@extends('template.template')
@section('content')
<div class="main m-4">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="/dasboard">
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
            <a href="">Add Majors</a>
          </li>
        </ul>
    </div>
    <div class="card bg-white p-5 ">
        <form action="/add/majors" method="post">
            @csrf
            <h4 class="text-primary fw-bold">Add Majors</h4>
            <div class="mb-3">
                <label for="full_name" class="form-label">Major name</label>
                <input type="text" class="form-control" id="full_name" placeholder="Enter major name" name="major_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" placeholder="Enter description" class="form-control"></textarea>
              </div>
              <input type="submit" class="btn btn-primary" value="Simpan">
              <a href="/admin/majors" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>


@endsection

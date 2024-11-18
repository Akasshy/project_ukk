@extends('template.template')
@section('content')
<div class="main m-4">
    <div class="page-header">
        {{-- <h3 class="fw-bold mb-3">DataTables.Net</h3> --}}
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
            <a href="#">Users</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="">Add Users</a>
          </li>
        </ul>
    </div>
    <div class="card bg-white p-5 ">
        <form action="/add/user" method="post">
            @csrf
            <h4 class="text-primary fw-bold">Add Users</h4>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" placeholder="Enter full name" name="full_name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone_number" placeholder="Enter phone number" name="phone_number" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                    <option value="assessor">Assessor</option>
                </select>
            </div>
            <div class="mb-3" id="student-fields"  style="display: none;">
              <div>
                  <label for="nisn" class="form-label">Nisn</label>
                  <input type="text" name="nisn" id="nisn" placeholder="Enter nisn" class="form-control">
              </div>
              <div>
                  <label for="grade_level" class="form-label">Grade Level</label>
                  <select name="grade_level"  id="grade_level" class="form-select">
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
              </div>
              <div>
                  <label for="major_id" class="form-label">Major</label>
                  <select name="major_id" id="major_id" class="form-select">
                      @foreach($majors as $major)
                          <option value="{{ $major->id }}">{{ $major->major_name }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="mb-3" id="assessor-fields" style="display: none">
              <div>
                <label for="assessor_type" class="form-label">Assessor Type</label>
                <select name="assessor_type" id="assessor_type" class="form-select">
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                </select>
              </div>
              <div>
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" placeholder="Enter description" class="form-control"></textarea>
              </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Simpan">
            <a href="/users" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
     <script>
        document.getElementById('role').addEventListener('change', function () {
            const role = this.value;

            // Referensi ke div input tambahan
            const studentFields = document.getElementById('student-fields');
            const assessorFields = document.getElementById('assessor-fields');

            // Reset semua input tambahan
            studentFields.style.display = 'none';
            assessorFields.style.display = 'none';

            // Tampilkan input tambahan berdasarkan role
            if (role === 'student') {
                studentFields.style.display = 'block';
            } else if (role === 'assessor') {
                assessorFields.style.display = 'block';
            }
        });
      </script>
@endsection

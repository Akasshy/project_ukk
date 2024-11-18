@extends('template.template')
@section('content')
<div class="main m-4">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="/users">Users</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="">Edit User</a></li>
        </ul>
    </div>
    <div class="card bg-white p-5">
        <form action="/user/{{ $user->id }}/update" method="post">
            @csrf
            <h4 class="text-primary fw-bold">Edit User</h4>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                       value="{{ $user->full_name }}" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="{{ $user->username }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number"
                       value="{{ $user->phone_number }}" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="assessor" {{ $user->role === 'assessor' ? 'selected' : '' }}>Assessor</option>
                </select>
            </div>

            {{-- Student Specific Fields --}}
            @if ($user->role==='student')

            <div class="mb-3" id="student-fields" style="display: {{ $user->role === 'student' ? 'block' : 'none' }};">
                <label for="nisn" class="form-label">Nisn</label>
                <input type="text" class="form-control" id="nisn" name="nisn"
                       value="{{ $user->student->nisn ?? '' }}">
                <label for="grade_level" class="form-label">Grade Level</label>
                <select class="form-select" id="grade_level" name="grade_level">
                    <option value="10" {{ $user->student->grade_level == 10 ? 'selected' : '' }}>10</option>
                    <option value="11" {{ $user->student->grade_level == 11 ? 'selected' : '' }}>11</option>
                    <option value="12" {{ $user->student->grade_level == 12 ? 'selected' : '' }}>12</option>
                </select>
                <label for="major_id" class="form-label">Major</label>
                <select class="form-select" id="major_id" name="major_id">
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}"
                                {{ ($user->student->major_id ?? '') == $major->id ? 'selected' : '' }}>
                            {{ $major->major_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            @if ($user->role=='assessor')

            {{-- Assessor Specific Fields --}}
            <div class="mb-3" id="assessor-fields" style="display: {{ $user->role === 'assessor' ? 'block' : 'none' }};">
                <label for="assessor_type" class="form-label">Assessor Type</label>
                <select class="form-select" id="assessor_type" name="assessor_type">
                    <option value="internal" {{ ($user->assessor->assessor_type ?? '') === 'internal' ? 'selected' : '' }}>Internal</option>
                    <option value="external" {{ ($user->assessor->assessor_type ?? '') === 'external' ? 'selected' : '' }}>External</option>
                </select>
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $user->assessor->description ?? '' }}</textarea>
            </div>
            @endif
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const studentFields = document.getElementById('student-fields');
        const assessorFields = document.getElementById('assessor-fields');

        // Hide all role-specific fields
        studentFields.style.display = 'none';
        assessorFields.style.display = 'none';

        // Show fields based on selected role
        if (role === 'student') {
            studentFields.style.display = 'block';
        } else if (role === 'assessor') {
            assessorFields.style.display = 'block';
        }
    });

</script>

@endsection

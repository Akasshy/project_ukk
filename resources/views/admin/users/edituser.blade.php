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

            {{-- General Fields --}}
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
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                       value="{{ $user->phone_number ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                       placeholder="Ulangi password baru jika ingin mengubah">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="{{ $user->role }}" readonly required>
                {{-- <select class="form-select" id="role" name="role" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="assessor" {{ $user->role === 'assessor' ? 'selected' : '' }}>Assessor</option>
                </select> --}}
            </div>

            {{-- Role-Specific Fields --}}
            @if ($user->role == 'student')

            <div id="student-fields" style="">
                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn"
                           value="{{ $user->student->nisn ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <select class="form-select" id="grade_level" name="grade_level">
                        <option value="10" {{ ($user->student->grade_level ?? '') == 10 ? 'selected' : '' }}>10</option>
                        <option value="11" {{ ($user->student->grade_level ?? '') == 11 ? 'selected' : '' }}>11</option>
                        <option value="12" {{ ($user->student->grade_level ?? '') == 12 ? 'selected' : '' }}>12</option>
                    </select>
                </div>
                <div class="mb-3">
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
            </div>
            @endif

            @if ($user->role == 'assessor')

            <div id="assessor-fields" style="">
                <div class="mb-3">
                    <label for="assessor_type" class="form-label">Assessor Type</label>
                    <select class="form-select" id="assessor_type" name="assessor_type">
                        <option value="internal" {{ ($user->assessor->assessor_type ?? '') === 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="external" {{ ($user->assessor->assessor_type ?? '') === 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $user->assessor->description ?? '' }}</textarea>
                </div>
            </div>
            @endif
            <input type="submit" class="btn btn-primary" value="Update">
            <a href="/users" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('student-fields');
        const assessorFields = document.getElementById('assessor-fields');

        const updateFieldsVisibility = () => {
            const role = roleSelect.value;

            studentFields.style.display = role === 'student' ? 'block' : 'none';
            assessorFields.style.display = role === 'assessor' ? 'block' : 'none';
        };

        // Run on page load and on role change
        updateFieldsVisibility();
        roleSelect.addEventListener('change', updateFieldsVisibility);
    });
</script> --}}
@endsection

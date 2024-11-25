@extends('template.template')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Profil {{ ucfirst($role) }}</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">Informasi Dasar</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>{{ $user->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Passoword</th>
                        <td>Jika tidak di ubah maka <b>SMK YPC</b></td>
                    </tr>
                </tbody>
            </table>
            <a href="/dasboard" class="btn btn-danger mt-3 me-4">Back</a>
            <a href="/profile/edit/{{ $user->id }}" class="btn btn-primary mt-3">Edit Profil</a>
        </div>
    </div>
</div>
@endsection

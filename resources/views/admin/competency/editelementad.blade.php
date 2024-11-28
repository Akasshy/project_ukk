@extends('template.templateassessor')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
<link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

<div class="main p-3">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="/standars">Standar Competency</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item fw-bold"><a href="">Edit Element</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Element Competency</h4>
                </div>
                <div class="card-body">
                    <form action="/update/element/admin/{{ $element->id }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="criteria" class="form-label">Criteria</label>
                            <textarea name="criteria" id="criteria" class="form-control" rows="4" required>{{ $element->criteria }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="competency_id" class="form-label">Competency Standard</label>
                            <select name="competency_id" id="competency_id" class="form-control" required>
                                @foreach ($standards as $standard)
                                    <option value="{{ $standard->id }}"
                                        @if ($standard->id == $element->competency_id) selected @endif>
                                        {{ $standard->unit_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/admin/standars" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endsection

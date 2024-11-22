@extends('template.templateassessor')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
{{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif --}}

<div class="main p-3">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard/as">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Assessor</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="">Element Kompetensi</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="card-title">Element Kompetensi</h4>
                </div> --}}
                <div class="card-body">
                    @foreach ($standars as $item)
                    <div class="pb-4" style="border-bottom: 1px solid black">
                        <div class="d-flex align-items-center pt-4">
                            <h5 class="card-title">Element competency dari</h5>
                            <h5 class="ms-4">{{ $item->unit_code }}</h5>
                            <h5 class="ms-4">{{ $item->unit_title }}</h5>
                            <button type="button" class="btn btn-black ms-auto me-4" data-bs-toggle="modal" data-bs-target="#modalAddElement{{ $item->id }}">Add Element</button>
                        </div>

                        <!-- Modal for Add Element -->
                        <div class="modal fade" id="modalAddElement{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Element for {{ $item->unit_title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/add/element" method="POST">
                                            @csrf
                                            <input type="hidden" name="competency_id" value="{{ $item->id }}">
                                            <div class="mb-3">
                                                <label for="criteria" class="form-label">Criteria</label>
                                                <textarea name="criteria" class="form-control" id="criteria" rows="4" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <table class="table table-bordered mt-4 table-head-bg-black">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Criteria</th>
                                    <th style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->elements as $index => $element)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <p style="font-size: 10px">{{ $element->criteria }}</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-link btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditElement{{ $element->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="javascript:void(0)" class="btn btn-link btn-danger" onclick="confirmDeleteElement({{ $element->id }})">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal for Edit Element -->
                                <div class="modal fade" id="modalEditElement{{ $element->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Element</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update/element/{{ $element->id }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="competency_id" value="{{ $item->id }}">
                                                    <div class="mb-3">
                                                        <label for="criteria" class="form-label">Criteria</label>
                                                        <textarea name="criteria" class="form-control" id="criteria" rows="4" required>{{ $element->criteria }}</textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
   @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
    function confirmDeleteElement(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke route delete
                window.location.href = `/delete/element/${id}`;
            }
        });
    }
</script>
@endsection

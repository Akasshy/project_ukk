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
            <li class="nav-item"><a href="/standars">Standar competency</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item fw-bold"><a href="">Element competency</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title me-auto">Element Competency : {{ $name }}</h4>
                        {{-- <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            Tambah Element
                        </button> --}}
                        <a href="/vadd/element/{{ $id_st }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="table-responsive pt-3">
                    <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Criteria</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th><a href="/standars" class="btn btn-danger">Back</a></th>
                        </tfoot>
                        <tbody>
                            @foreach ($standars as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->criteria }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-link btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditElement{{ $item->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <!-- Tombol Hapus dengan SweetAlert -->
                                        <button class="btn btn-link btn-danger" onclick="confirmDeleteElement({{ $item->id }})">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditElement{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Element</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/update/element/{{ $item->id }}" method="POST">
                                                @csrf
                                                {{-- @method('PUT') --}}
                                                <input type="hidden" name="competency_id" value="{{ $item->id }}">
                                                <div class="mb-3">
                                                    <label for="criteria" class="form-label">Criteria</label>
                                                    <textarea name="criteria" class="form-control" id="criteria" rows="4" required>{{ $item->criteria }}</textarea>
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
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function () {
            sessionStorage.fonts = true;
        },
    });
</script>

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

<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#add-row').DataTable({
            pageLength: 5,
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });
    });
</script>
@endsection

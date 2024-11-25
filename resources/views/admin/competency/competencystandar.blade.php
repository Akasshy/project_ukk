@extends('template.template')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
<link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
<div class="main p-3">
    <div class="page-header">
      {{-- <h3 class="fw-bold mb-3">DataTables.Net</h3> --}}
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="/dasboard/as">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Assessor</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="">Standar Kompetensi</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title me-auto">Standar Kompetensi</h4>
                <a type="button" class="btn btn-primary ms-auto" href="/vaddst">
                    Add standar
                </a>
            </div>
          </div>
            <div class="table-responsive pt-3">
              <table id="add-row" class="display table table-striped table-hover table-head-bg-black">
                <thead>
                  <tr>
                    <th>Unit Code</th>
                    <th>Unit Title</th>
                    <th>Unit Description</th>
                    <th>Major</th>
                    <th>Assessor</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Unit Code</th>
                    <th>Unit Title</th>
                    <th>Unit Description</th>
                    <th>Major</th>
                    <th>Assessor</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                    @foreach ($standars as $key => $item)
                    <tr>
                        <td>{{$item->unit_code}}</td>
                        <td>{{$item->unit_title}}</td>
                        <td>{{$item->unit_description}}</td>
                        <td>{{$item->major->major_name}}</td>
                        <td>{{$item->assessor->user->full_name}}</td>
                        <td>
                            <!-- Dropdown Action -->
                            <div class="form-button-action">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $item->id }}">
                                        <!-- Tombol Detail -->
                                        <li>
                                            <a href="/detail/standar/{{ $item->id }}" class="dropdown-item">
                                                <i class="fa fa-info-circle me-2"></i>Detail
                                            </a>
                                        </li>
                                        <!-- Tombol Edit -->
                                        <li>
                                            <a href="/veditst/{{ $item->id }}" class="dropdown-item">
                                                <i class="fa fa-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <!-- Tombol Delete -->
                                        <li>
                                            <a href="javascript:void(0)" class="dropdown-item text-danger" onclick="confirmDelete({{ $item->id }})">
                                                <i class="fa fa-times me-2"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
       @endif
          function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke route delete
                window.location.href = `/delete/st/${id}`;
            }
        });
    }
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
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>

    <script>
      $(document).ready(function () {
        $('#add-row').DataTable({
          pageLength: 5,
        });

        $('#addRowButton').click(function () {
          var action = `
            <td>
              <div class="form-button-action">
                <button class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button>
                <button class="btn btn-link btn-danger"><i class="fa fa-times"></i></button>
              </div>
            </td>`;
          $('#add-row').DataTable().row.add([
            $('#addName').val(),
            $('#addPosition').val(),
            $('#addOffice').val(),
            action,
          ]).draw();
          $('#addRowModal').modal('hide');
        });
      });
    </script>


@endsection

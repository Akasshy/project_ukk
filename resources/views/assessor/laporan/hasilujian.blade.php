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
          <a href="#" class="fw-bold">Hasil ujian</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title me-auto">Hasil ujian</h4>
                <form action="/result/major" method="GET" id="form-standar" class="w-75">
                    <select name="standar_id" id="standar-select" class="form-select w-100" onchange="submitForm()">
                        @foreach ($standars as $item)
                            <option value="{{ $item->id }}" {{ request('standar_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->unit_code }}, {{ $item->unit_title }}
                            </option>
                        @endforeach
                    </select>
                </form>

            </div>
          </div>
          <div class="table-responsive pt-3">
            <table id="add-row" class="display table table-striped table-hover table-head-bg-black">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Final Score</th>
                        <th>Status</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $key => $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student['student_name'] }}</td>
                            <td>{{ $student['final_score'] }}%</td>
                            <td>
                                <span class="badge {{ $student['status'] == 'Competent' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $student['status'] }}
                                </span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    <a href="/results/major/{{ $student['student_id'] }}" class="btn btn-info btn-xl ">
                                        <i class="fas fa-edit text-center"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data untuk standar ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      function submitForm() {
        const form = document.getElementById('form-standar');
        form.submit();
     }
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

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

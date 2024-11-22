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
          <a href="/dasboard/us">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/penilaians">Subject penilaian</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="" class="fw-bold">Pilih siswa</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title me-auto">Data Siswa</h4>
                <form action="" method="get" class="w-75 ms-auto">
                    <select name="" id="" class="form-select w-75 ms-auto">
                        @foreach ($students as $key => $item)
                            <option value="">{{$item->nisn}} , {{$item->user->full_name}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
          </div>
            <div class="table-responsive pt-3">
              <table id="add-row" class="display table table-striped table-hover table-head-bg-black">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Nisn</th>
                    <th>Grade Lvl/Kelas</th>
                    <th>Major</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($students as $key => $item)
                    <tr>
                      <td>{{$item->user->full_name}}</td>
                      <td>{{$item->nisn}}</td>
                      <td>{{$item->grade_level}}</td>
                      <td>{{$item->major->major_name}}</td>
                      <td>
                        <div class="form-button-action">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $item->id }}">
                                    <!-- Tombol Detail -->
                                    <li>
                                        <a href="/menilai/{{ $standars->id }}/{{ $item->id }}" class="dropdown-item">
                                            <i class="fa fa-info-circle me-2"></i>menilai
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

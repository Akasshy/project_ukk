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
            <a href="/penilaians">Subject penilaian</a>
        </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="" class="/select/siswa">Pilih siswa</a>
        </li>
        </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="" class="fw-bold">Menilai</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title me-auto">Menilai</h4>
            </div>
          </div>
            <div class="table-responsive pt-3">
              <table id="add-row" class="display table table-striped table-hover table-head-bg-black">
                <thead>
                  <tr>
                    <th style="width: 6%">No</th>
                    <th>Criteria</th>
                    <th style="width: 23%">Action</th>
                  </tr>
                </thead>
                <form action="/add/examination/{{ $student_id }}/{{ $standar_id->id }}" method="post">
                    @csrf
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>
                                <input type="submit" class="btn btn-primary w-100 mb-2" value="Menilai">
                                <input type="submit" class="btn btn-success me-3 ms-4" value="All 1">
                                <input type="submit" class="btn btn-danger " value="All 0">
                                {{-- <input type="text" type="hidden" style="display: none" name="standar_id" value="{{ $standar_id }}"> --}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($element as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->criteria }}</td>
                            <td>
                                <select name="status[{{ $item->id }}]" class="form-select status-select">
                                    <option value="1">Selesai</option>
                                    <option value="0">Tidak Selesai</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </form>
              </table>
            </div>
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
    document.addEventListener('DOMContentLoaded', () => {
        const allOneBtn = document.querySelector('.btn-success'); // Tombol "All 1"
        const allZeroBtn = document.querySelector('.btn-danger'); // Tombol "All 0"
        const selects = document.querySelectorAll('.status-select'); // Semua select option

        // Fungsi untuk mengatur nilai select
        const setAllSelects = (value) => {
            selects.forEach(select => {
                select.value = value;
            });
        };

        // Event listener untuk tombol "All 1"
        allOneBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Mencegah submit form
            setAllSelects('1');
        });

        // Event listener untuk tombol "All 0"
        allZeroBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Mencegah submit form
            setAllSelects('0');
        });
    });
</script>

@endsection

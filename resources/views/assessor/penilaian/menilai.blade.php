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
                <form action="/addExamination/{{ $standar_id->id }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title me-auto">Menilai</h4>
                            <div class="w-75 ms-auto">
                                <select name="student_id" id="studentSelect" class="form-select w-75 ms-auto">
                                    @foreach ($students as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nisn }}, {{ $item->user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="dynamicTable">
                        <div class="table-responsive pt-3">
                            <table id="add-row" class="display table table-striped table-hover table-head-bg-black">
                                <thead>
                                    <tr>
                                        <th style="width: 6%">No</th>
                                        <th>Criteria</th>
                                        <th style="width: 23%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <input type="submit" class="btn btn-primary w-100 mb-2" value="Menilai">
                                            <input type="submit" class="btn btn-success me-3 ms-4" value="All 1">
                                            <input type="submit" class="btn btn-danger" value="All 0">
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($element as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->criteria }}</td>
                                        <td>
                                            @php
                                                $exam = $examinations->has($students->first()->id ?? null)
                                                    ? $examinations[$students->first()->id]->firstWhere('element_id', $item->id)
                                                    : null;
                                                $status = $exam ? $exam->status : null;
                                            @endphp
                                            <select name="status[{{ $item->id }}]" class="form-select status-select">
                                                <option value="1" {{ $status == 1 ? 'selected' : '' }}>Selesai</option>
                                                <option value="0" {{ $status == 0 ? 'selected' : '' }}>Tidak Selesai</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('studentSelect').addEventListener('change', function () {
                const studentId = this.value;
                const standarId = "{{ $standar_id->id }}";

                // AJAX Request untuk mengganti tabel berdasarkan student_id
                fetch(`/get-examination-data/${standarId}/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.querySelector('#dynamicTable tbody');
                        tableBody.innerHTML = ''; // Kosongkan isi tabel

                        // Isi ulang tabel dengan data baru
                        data.elements.forEach((element, index) => {
                            const status = data.examinations[element.id] ?? null;
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${element.criteria}</td>
                                    <td>
                                        <select name="status[${element.id}]" class="form-select status-select">
                                            <option value="1" ${status == 1 ? 'selected' : ''}>Selesai</option>
                                            <option value="0" ${status == 0 ? 'selected' : ''}>Tidak Selesai</option>
                                        </select>
                                    </td>
                                </tr>
                            `;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });
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

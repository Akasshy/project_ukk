@extends('template.templateassessor')
@section('content')
<!-- Import CSS -->
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
                <a href="/dasboard/as">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#" class="fw-bold">Hasil Ujian</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title me-auto">Hasil Ujian</h4>
                    </div>
                    <select name="standar_id" id="standar-select" class="form-select w-100">
                        @foreach ($standars as $item)
                            <option value="{{ $item->id }}" {{ request('standar_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->unit_code }}, {{ $item->unit_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive pt-3">
                    <table id="results-table" class="display table table-striped table-hover table-head-bg-black">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Final Score</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data akan dimuat melalui AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import JS -->
<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
<script>
    $(document).ready(function () {
        const dataTable = $('#results-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/get-results', // Endpoint untuk data hasil
                data: function (d) {
                    d.standar_id = $('#standar-select').val(); // Mengirim standar_id sebagai parameter
                },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'student_name', name: 'student_name' },
                { data: 'final_score', name: 'final_score', render: (data) => `${data}%` },
                {
                    data: 'status',
                    name: 'status',
                    render: (data) => {
                        let badgeClass = '';

                        // Tentukan warna badge sesuai dengan status
                        if (data === 'Sangat Kompeten') {
                            badgeClass = 'bg-success';  // Hijau untuk sangat kompeten
                        } else if (data === 'Kompeten') {
                            badgeClass = 'bg-primary';  // Biru untuk kompeten
                        } else if (data === 'Cukup Kompeten') {
                            badgeClass = 'bg-warning';  // Kuning untuk cukup kompeten
                        } else {
                            badgeClass = 'bg-danger';  // Merah untuk belum kompeten
                        }

                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="form-button-action">
                                <a href="/menilai/${row.student_id}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Detail
                                </a>
                            </div>`;
                    },
                },
            ],
        });

        // Event listener untuk dropdown standar
        $('#standar-select').on('change', function () {
            dataTable.ajax.reload(); // Refresh data tabel
        });

        // SweetAlert untuk pesan sukses atau error
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
    });
</script>
@endsection

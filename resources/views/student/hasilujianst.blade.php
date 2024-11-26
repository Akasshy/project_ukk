@extends('template.templatest')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
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
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <select name="standar_id" id="standar-select" class="form-select w-75">
                    @foreach ($standars as $item)
                        <option value="{{ $item->id }}" {{ $standar_id == $item->id ? 'selected' : '' }}>
                            {{ $item->unit_code }}, {{ $item->unit_title }}
                        </option>
                    @endforeach
                </select>
                <button id="generate-pdf" class="btn btn-success w-25 ms-2">
                    <i class="icon-file-pdf"></i> Cetak PDF
                </button>
            </div>
        </div>
    </div>
    <div class="row" id="results-container">
        {{-- Data akan dimuat melalui AJAX --}}
    </div>
</div>

<style>
    .student-card {
        width: 100%; /* Memenuhi lebar grid */
        height: 250px; /* Tinggi tetap */
    }
    .student-card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .student-card .btn-detail {
        align-self: center;
    }
</style>

<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script>
    $('#generate-pdf').on('click', function () {
        const standarId = $('#standar-select').val();

        // Perform an AJAX request to get the results and check if any student has a score <= 60
        $.ajax({
            url: '/get-resultst',
            method: 'GET',
            data: { standar_id: standarId },
            success: function (response) {
                // Check if there's any student with a score <= 60
                const hasLowScore = response.data.some(result => result.final_score <= 60);

                if (hasLowScore) {
                    // Show SweetAlert notification
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Tidak bisa mencetak PDF karena ada siswa dengan skor kurang dari atau sama dengan 60.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    // If no student has a low score, proceed to generate PDF
                    const pdfUrl = `/generate/pdf?standar_id=${standarId}`;
                    window.location.href = pdfUrl;
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memuat data.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });

    $(document).ready(function () {
        function loadResults() {
            const standarId = $('#standar-select').val();

            $.ajax({
                url: '/get-resultst',
                method: 'GET',
                data: { standar_id: standarId },
                success: function (response) {
                    const resultsContainer = $('#results-container');
                    resultsContainer.empty();

                    if (response.data.length === 0) {
                        resultsContainer.append(`
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    Tidak ada data hasil ujian untuk standar kompetensi ini.
                                </div>
                            </div>
                        `);
                        return;
                    }

                    response.data.forEach(result => {
                        let badgeClass = '';

                        if (result.status === 'Sangat Kompeten') {
                            badgeClass = 'bg-success';
                        } else if (result.status === 'Kompeten') {
                            badgeClass = 'bg-primary';
                        } else if (result.status === 'Cukup Kompeten') {
                            badgeClass = 'bg-warning';
                        } else {
                            badgeClass = 'bg-danger';
                        }

                        const detailUrl = `/detail/laporan/student/${result.student_id}/${result.standar_id}`;

                        const cardHtml = `
                            <div class="col-md-12 mb-3">
                                <div class="card student-card">
                                    <div class="card-body student-card-body">
                                        <div>
                                            <h5 class="card-title">${result.student_name}</h5>
                                            <p class="card-text">
                                                <strong>Final Score:</strong> ${result.final_score}%<br>
                                                <strong>Status:</strong>
                                                <span class="badge ${badgeClass}">${result.status}</span>
                                            </p>
                                        </div>
                                        <a href="${detailUrl}" class="btn btn-primary btn-detail">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.append(cardHtml);
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memuat data.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        }

        // Muat hasil pertama kali
        loadResults();

        // Event listener untuk dropdown
        $('#standar-select').on('change', loadResults);

        // Notifikasi untuk session success atau error
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

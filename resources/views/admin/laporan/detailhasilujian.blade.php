@extends('template.template')

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
                <a href="#" class="fw-bold">Detail Laporan</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Laporan</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama Siswa</th>
                                <td>{{ $details->first()->student->user->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Unit Kompetensi</th>
                                <td>{{ $details->first()->standar->unit_title }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Ujian</th>
                                <td>{{ \Carbon\Carbon::parse($details->first()->exam_date)->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Element Kompetensi</th>
                                <td>
                                    <ul>
                                        @foreach ($details as $detail)
                                            <li>
                                                {{ $detail->element->criteria }}
                                                <span class="badge {{ $detail->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $detail->status == 1 ? 'Selesai' : 'Belum Selesai' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $details->first()->comments ?? 'Tidak ada catatan' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <a href="/hasil-ujian" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

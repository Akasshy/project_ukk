@extends('template.templateassessor')
@section('content')
<div class="main p-3">
    <div class="page-header">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="/dashboard">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="/standars">Standar Competency</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item fw-bold"><a href="">Tambah Element Competency</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Element Competency</h4>
        </div>
        <div class="card-body">
            <form action="/add/element/{{ $competency_id }}" method="POST">
                @csrf
                <input type="hidden" name="competency_id" value="{{ $competency_id }}">

                <div id="criteria-container">
                    <!-- Input pertama -->
                    <div class="criteria-row mb-3">
                        <label for="criteria[]" class="form-label">Criteria</label>
                        <textarea name="criteria[]" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-success" id="add-criteria-row">
                        Tambah Criteria
                    </button>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/standars" class="btn btn-danger">Kembali</a>
                </div>
            </form>
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
    // Script untuk menambahkan input criteria
    document.getElementById('add-criteria-row').addEventListener('click', function () {
        const container = document.getElementById('criteria-container');

        // Membuat div baru untuk input criteria
        const newRow = document.createElement('div');
        newRow.classList.add('criteria-row', 'mb-3');

        newRow.innerHTML = `
            <label for="criteria[]" class="form-label">Criteria</label>
            <textarea name="criteria[]" class="form-control" rows="2" required></textarea>
            <button type="button" class="btn btn-danger mt-2 remove-criteria-row">Hapus</button>
        `;

        container.appendChild(newRow);
    });

    // Event untuk menghapus input criteria
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-criteria-row')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection

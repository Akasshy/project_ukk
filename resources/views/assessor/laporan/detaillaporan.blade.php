@extends('template.templateassessor')

@section('content')
<div class="container">
    <!-- Menampilkan pesan sukses jika ada -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Elemen</button>
            <!-- Tabel elemen -->
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Criteria</th>
                        <th>Competency</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($elements as $element)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $element->criteria }}</td>
                        <td>{{ $element->competency->name }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $element->id }}">Edit</button>
                            <!-- Tombol Hapus -->
                            <button class="btn btn-danger" onclick="confirmDeleteElement({{ $element->id }})">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Elemen -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Element Competency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="/add/element" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="criteria" class="form-label">Criteria</label>
                        <textarea name="criteria" class="form-control" id="criteria" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="competency_id" class="form-label">Competency ID</label>
                        <select name="competency_id" class="form-control" id="competency_id" required>
                            @foreach ($competencies as $competency)
                                <option value="{{ $competency->id }}">{{ $competency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Elemen -->
@foreach ($elements as $element)
<div class="modal fade" id="modalEdit{{ $element->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Element Competency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="/update/element/{{ $element->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="criteria" class="form-label">Criteria</label>
                        <textarea name="criteria" class="form-control" id="criteria" rows="4" required>{{ $element->criteria }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="competency_id" class="form-label">Competency ID</label>
                        <select name="competency_id" class="form-control" id="competency_id" required>
                            @foreach ($competencies as $competency)
                                <option value="{{ $competency->id }}" {{ $competency->id == $element->competency_id ? 'selected' : '' }}>
                                    {{ $competency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
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
@endsection

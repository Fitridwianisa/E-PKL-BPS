@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Edit Artikel</h5>
            <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4 align-items-start">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul artikel</label>
                            <input type="text" name="judul" id="judul" class="form-control border-primary-subtle" value="{{ old('judul', $artikel->judul) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label fw-semibold">Isi artikel</label>
                            <textarea name="konten" id="konten" rows="5" class="form-control border-primary-subtle" required>{{ old('konten', $artikel->konten) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Ganti gambar</label>
                        @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Artikel" class="img-fluid mb-2 rounded shadow-sm">
                        @endif
                        <input type="file" name="gambar" accept="image/*" class="d-none" id="uploadGambar">
                        <label for="uploadGambar" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-upload"></i> Upload gambar baru
                        </label>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.artikel') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Form Tambah Artikel --}}
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4 align-items-start">
                    {{-- Judul dan Konten --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul artikel</label>
                            <input type="text" name="judul" id="judul" class="form-control border-primary-subtle" placeholder="Masukan judul artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label fw-semibold">Isi artikel</label>
                            <textarea name="konten" id="konten" rows="5" class="form-control border-primary-subtle" placeholder="Masukan detail isi" required></textarea>
                        </div>
                    </div>

                    {{-- Upload gambar --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Pilih gambar</label>
                        <input type="file" name="gambar" accept="image/*" class="d-none" id="uploadGambar">
                        <label for="uploadGambar" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-upload"></i> Upload gambar
                        </label>
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-outline-primary">Batal</a>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Artikel --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">List Artikel</h5>
                <div class="input-group" style="max-width: 200px;">
                    <input type="text" class="form-control" placeholder="Cari...">
                    <span class="input-group-text bg-white"><i class="bi bi-funnel"></i></span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-start">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 50px;"><i class="bi bi-arrow-down-up"></i></th>
                            <th>Judul artikel</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($artikels as $artikel)
                            <tr>
                                <td>#</td>
                                <td>
                                    <div>{{ $artikel->judul }}</div>
                                </td>
                                <td>
                                    <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary bg-opacity-25 border-0 text-white fw-semibold">• Hapus</button>
                                    </form>
                                    <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-sm btn-primary bg-opacity-25 border-0 text-white fw-semibold">• Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada artikel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

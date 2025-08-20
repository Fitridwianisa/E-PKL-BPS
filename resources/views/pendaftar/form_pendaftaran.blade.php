@extends('layouts.app')

@section('title', 'Formulir Pendaftaran')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold text-center mb-4">FORMULIR PENDAFTARAN</h4>

    {{-- Form Biodata --}}
    <form action="{{ route('pendaftaran.store.biodata') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h6 class="fw-bold">Biodata</h6>
        <div class="mb-3">
            <label>Nama <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama', $biodata->nama ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Instansi / Sekolah <span class="text-danger">*</span></label>
            <input type="text" name="instansi" class="form-control" required value="{{ old('instansi', $biodata->instansi ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Jurusan <span class="text-danger">*</span></label>
            <input type="text" name="jurusan" class="form-control" required value="{{ old('jurusan', $biodata->jurusan ?? '') }}">
        </div>
        <div class="mb-3">
            <label>NIM / NIS <span class="text-danger">*</span></label>
            <input type="text" name="nim_nis" class="form-control" required value="{{ old('nim_nis', $biodata->nim_nis ?? '') }}">
        </div>
        <div class="mb-3">
            <label>No. Whatsapp <span class="text-danger">*</span></label>
            <input type="text" name="no_wa" class="form-control" required value="{{ old('no_wa', $biodata->no_wa ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Foto 3:4 (PNG/JPG) <span class="text-danger">*</span></label>
            <input type="file" name="foto" class="form-control" accept="image/png, image/jpeg" onchange="previewFoto(event)">
            <img id="preview" src="{{ $biodata && $biodata->foto ? asset('storage/'.$biodata->foto) : '' }}" alt="Preview Foto" class="img-thumbnail mt-2" style="max-height: 150px;">
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan Biodata</button>
        </div>
    </form>

    <hr class="my-5">

    {{-- Form Dokumen --}}
    <form action="{{ route('pendaftaran.store.pendaftaran') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h6 class="fw-bold">Dokumen</h6>
        <p class="text-muted small">Format .PDF maksimal 2MB</p>
        <div class="mb-3">
            <label>Surat Pengantar <span class="text-danger">*</span></label>
            <input type="file" name="surat_pengantar" class="form-control" accept="application/pdf" required>
        </div>
        <div class="mb-3">
            <label>Proposal <span class="text-danger">*</span></label>
            <input type="file" name="proposal" class="form-control" accept="application/pdf" required>
        </div>
        <h6 class="fw-bold">Penempatan</h6>
        <div class="mb-3">
            <label>Jenis Magang<span class="text-danger">*</span></label>
            <select name="jenis_magang" class="form-control" required>
                <option value="">-- Pilih Jenis Magang --</option>
                <option value="mandiri" {{ old('jenis_magang') == 'mandiri' ? 'selected' : '' }}>Mandiri </option>
                <option value="wajib" {{ old('jenis_magang') == 'wajib' ? 'selected' : '' }}>Wajib</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai (bulan/hari/tahun)<span class="text-danger">*</span></label>
            <input type="date" name="tanggal_mulai" class="form-control" required value="{{ old('tanggal_mulai') }}">
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai (bulan/hari/tahun)<span class="text-danger">*</span></label>
            <input type="date" name="tanggal_selesai" class="form-control" required value="{{ old('tanggal_selesai') }}">
        </div>
        <div class="mb-3">
            <label>Bagian Penempatan<span class="text-danger">*</span></label>
                <select name="bagian_penempatan" class="form-control" required>
                    <option value="" {{ old('bagian_penempatan') == '' ? 'selected' : '' }}>-- Pilih bagian --</option>
                    <option value="umum" {{ old('bagian_penempatan') == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="humas" {{ old('bagian_penempatan') == 'humas' ? 'selected' : '' }}>Humas, Pojok Statistik, PSS</option>
                    <option value="ipds" {{ old('bagian_penempatan') == 'ipds' ? 'selected' : '' }}>IPDS</option>
                    <option value="statistik_sosial" {{ old('bagian_penempatan') == 'statistik_sosial' ? 'selected' : '' }}>Statistik sosial</option>
                    <option value="statistik_distribusi" {{ old('bagian_penempatan') == 'statistik_distribusi' ? 'selected' : '' }}>Statistik distribusi</option>
                    <option value="statistik_produksi" {{ old('bagian_penempatan') == 'statistik_produksi' ? 'selected' : '' }}>Statistik produksi</option>
                    <option value="newilis" {{ old('bagian_penempatan') == 'newilis' ? 'selected' : '' }}>Newilis</option>
                    <option value="sakip" {{ old('bagian_penempatan') == 'sakip' ? 'selected' : '' }}>SAKIP, ZI, EPSS</option>
                </select>
        </div>
        <small class="form-text text-muted">
            <strong>*SAKIP</strong>: Sistem Akuntabilitas Kinerja Instansi Pemerintah,<br>
            <strong>*PSS</strong>: Pembinaan Statistik Sektoral,<br>
            <strong>*ZI</strong>: Zona Integritas,<br>
            <strong>*EPSS</strong>: Evaluasi Penyelenggaraan Statistik Sektoral <br>
            <strong>*IPDS</strong>: Integrasi Pengolahan dan Diseminasi Statistik <br>
        </small><br>
        <div>
            
        </div>
        <div class="form-check mb-4">
            <input type="checkbox" name="siap_ditempatkan" class="form-check-input" id="siapDitempatkan" {{ old('siap_ditempatkan', true) ? 'checked' : '' }}>
            <label class="form-check-label small text-muted" for="siapDitempatkan">
                Saya bersedia ditempatkan di bidang lain sesuai keputusan BPS
            </label>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            });
        @endif
    </script>
@endsection


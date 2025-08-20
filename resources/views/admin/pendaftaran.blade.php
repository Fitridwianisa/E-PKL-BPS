@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5><strong>DATA PELAMAR</strong></h5>
            <small class="text-muted">List Berdasarkan tanggal Terlama</small>
        </div>
        <div class="d-flex align-items-center">
            <div class="me-3 text-end">
                <span class="bg-light px-3 py-2 rounded border">
                    Total Pendaftar Saat ini <strong class="text-primary">{{ $pendaftarans->total() }} Orang</strong>
                </span>
            </div>
            <!-- Form Search -->
            <form method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari..." style="max-width: 200px;">
                <button type="submit" class="btn btn-outline-secondary ms-2"><i class="fa fa-filter"></i></button>
            </form>
        </div>
    </div>

    @php $search = request('search'); @endphp

    @if(!$search || $pendaftarans->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Posisi</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftarans as $index => $pendaftaran)
                    @php
                        $match = false;
                        if($search) {
                            $searchLower = strtolower($search);
                            $match = str_contains(strtolower($pendaftaran->user->nama ?? ''), $searchLower) ||
                                     str_contains(strtolower($pendaftaran->user->email ?? ''), $searchLower) ||
                                     str_contains(strtolower($pendaftaran->biodata->instansi ?? ''), $searchLower) ||
                                     str_contains(strtolower($pendaftaran->bagian_penempatan ?? ''), $searchLower);
                        }
                    @endphp
                    <tr class="text-center @if($match) table-highlight @endif">
                        <td>{{ $pendaftarans->firstItem() + $index }}</td>
                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                @if($pendaftaran->biodata && $pendaftaran->biodata->foto)
                                    <img src="{{ asset('storage/' . $pendaftaran->biodata->foto) }}" class="rounded-circle me-2" width="40" height="40">
                                @else
                                    <div class="rounded-circle bg-secondary me-2" style="width:40px; height:40px;"></div>
                                @endif
                                <div>
                                    <div><strong>{{ $pendaftaran->user->nama ?? '-' }}</strong></div>
                                    <small class="text-muted">{{ $pendaftaran->user->email ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $pendaftaran->biodata->instansi ?? '-' }}</td>
                        <td>{{ $pendaftaran->bagian_penempatan ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d M Y') }} <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d M Y') }} </small>
                        </td>
                        <td>
                            @if ($pendaftaran->status == 'diterima')
                                <span class="badge bg-success">Sudah konfirmasi</span>
                            @elseif ($pendaftaran->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum konfirmasi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-outline-dark btn-sm">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4 d-flex justify-content-center">
        {{ $pendaftarans->links('pagination::bootstrap-5') }}
    </nav>
    @endif

    <!-- Overlay jika tidak ada hasil -->
    @if($search && $pendaftarans->count() == 0)
    <div id="no-data-overlay" class="overlay">
        <div class="overlay-content">
            <h5>Data tidak ditemukan</h5>
            <p>Tidak ada hasil untuk pencarian: "<strong>{{ $search }}</strong>"</p>
            <button id="close-overlay" class="btn btn-primary">Tutup</button>
        </div>
    </div>
    @endif
</div>

<style>
.table-highlight {
    border: 2px solid #0d6efd !important;
    background-color: #e7f1ff;
    transition: background 0.3s, border 0.3s;
}
.overlay {
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.5);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:1050;
}
.overlay-content {
    background:white;
    padding:2rem;
    border-radius:10px;
    text-align:center;
    max-width:400px;
}
</style>

<script>
const overlay = document.getElementById('no-data-overlay');
if(overlay){
    const closeOverlay = document.getElementById('close-overlay');
    closeOverlay.addEventListener('click', ()=>{
        window.location.href = "{{ route('admin.pendaftaran') }}";
    });
    overlay.addEventListener('click', (e)=>{
        if(e.target === overlay){
            window.location.href = "{{ route('admin.pendaftaran') }}";
        }
    });
}
</script>
@endsection

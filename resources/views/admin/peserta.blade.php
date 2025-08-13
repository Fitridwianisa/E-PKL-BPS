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
            <div>
                <input type="text" class="form-control" placeholder="Cari..." style="max-width: 200px;">
            </div>
            <button class="btn btn-outline-secondary ms-2"><i class="fa fa-filter"></i></button>
        </div>
    </div>

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
                @forelse ($pendaftarans as $index => $pendaftaran)
                <tr class="text-center">
                    <td>{{ $pendaftarans->firstItem() + $index }}</td>
                    <td class="text-start">
                        <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $pendaftaran->biodata->foto) }}" class="rounded-circle me-2" width="40" height="40">
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
                                @if ($pendaftaran->status == 'ditolak')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @elseif ($pendaftaran->status == 'diterima')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Diterima</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">Menunggu</span>
                                @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pendaftaran.showpeserta', $pendaftaran->id) }}" class="btn btn-outline-dark btn-sm">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data pendaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="mt-4 d-flex justify-content-center">
        {{ $pendaftarans->links() }}
    </nav>
</div>
@endsection

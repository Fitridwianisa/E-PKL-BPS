@extends('layouts.app')

@section('title', 'Dashboard Pendaftar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold">Lihat status penerimaan kamu</h5>
            <small class="text-primary">List terbaru berdasarkan tanggal apply</small>
        </div>
    </div>

    <div class="table-responsive">
        @if($pendaftaran->count() > 0)
            <table class="table align-middle">
                <thead class="bg-light text-dark">
                    <tr>
                        <th>No</th>
                        <th>Bagian Penempatan</th>
                        <th>Waktu magang</th>
                        <th>Status</th>
                        <th>Surat balasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->bagian_penempatan ?? '-' }}</td>
                            <td>{{ $item->tanggal_mulai  }}</td>
                            <td>
                                @if ($item->status == 'ditolak')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @elseif ($item->status == 'diterima')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Diterima</span>
                                @elseif ($item->status == 'selesai')
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">Selesai</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status === 'diterima')
                                    @if ($item->suratBalasans->count() > 0)
                                        @foreach ($item->suratBalasans as $sb)
                                            <a href="{{ asset('storage/' . $sb->file) }}" target="_blank">Lihat</a><br>
                                        @endforeach
                                    @else
                                        <span class="text-muted fst-italic">Belum dibalas</span>
                                    @endif
                                @else
                                    <span class="text-muted fst-italic">Belum dibalas</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada data pendaftaran.</p>
        @endif
    </div>
    <small>Informasi Lebih lanjut hubungi SI DILAN: 0815-5323-3444</small>
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

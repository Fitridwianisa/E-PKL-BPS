<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Magang</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
    
        .navbar-custom {
            background-color: #002B6B;
            font-size: 0.9rem; 
            line-height: 1.2; 
            padding-top: 0.25rem;   /* kecilkan atas */
            padding-bottom: 0.25rem;/* kecilkan bawah */
        }

        .hover-border {
            transition: all 0.3s ease-in-out;
        }

        body {
            padding-top: 65px; /* tinggi navbar */
        }

        .hover-border:hover {
            border-color: #0d6efd !important;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
        }

        /* Timeline */
        .timeline {
            position: relative;
            max-width: 800px;
            margin: auto;
        }
        .timeline::after {
            content: '';
            position: absolute;
            width: 4px;
            background-color: #0d6efd;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
        }
        .timeline-item {
            padding: 20px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            right: -10px;
            background-color: #fff;
            border: 4px solid #0d6efd;
            top: 15px;
            border-radius: 50%;
            z-index: 1;
            transition: transform 0.3s ease;
        }
        .timeline-item:hover::after {
            transform: scale(1.2);
            background-color: #0d6efd;
        }
        .timeline-item.left {
            left: 0;
            text-align: right;
        }
        .timeline-item.right {
            left: 50%;
            text-align: left;
        }
        .timeline-content {
            background: #e9f1ff;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            transition: transform 0.3s ease;
        }
        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(13, 110, 253, 0.2);
        }
        .timeline-content h5 {
            margin-top: 0;
            color: #0d6efd;
        }
        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 20px;
            }
            .timeline-item {
                width: 100%;
                padding-left: 60px;
                padding-right: 25px;
            }
            .timeline-item.right,
            .timeline-item.left {
                left: 0%;
                text-align: left;
            }
            .timeline-item::after {
                left: 10px;
            }
        }
    </style>
</head>
<body>

    {{-- Header --}}

    @include('layouts.header')

    {{-- Banner --}}
    <div class="bg-primary py-5 text-white text-center position-relative"
         style="background: url('/img/banner-bps.png') no-repeat center center / cover;">
        <div class="container">
            <h1 class="fw-bold">Informasi Magang BPS Kabupaten Kediri</h1>
        </div>
    </div>

    {{-- Konten --}}
    <div class="container mt-5">

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showTab('alur')">Alur Pendaftaran</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="showTab('peserta')">Daftar Peserta Magang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showTab('artikel')">Informasi Umum</a>
            </li>
        </ul>

        {{-- Tab Peserta --}}
        <div id="peserta" class="tab-content">
            @if($kuotaPenuh)
                <div class="alert alert-danger text-center">
                    Maaf kuota magang saat ini penuh sampai bulan {{ $lastTanggalSelesai }}
                </div>
            @endif
            <h5>Daftar Peserta Magang yang Diterima</h5>
            @if ($pesertaDiterima->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama</th>
                                <th>Instansi</th>
                                <th>Tanggal Magang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesertaDiterima as $peserta)
                                <tr>
                                    <td>{{ $peserta->user->nama ?? 'Nama tidak tersedia' }}</td>
                                    <td>{{ $peserta->biodata->instansi ?? '-' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($peserta->tanggal_mulai)->translatedFormat('d M Y') ?? '-' }}
                                        -
                                        {{ \Carbon\Carbon::parse($peserta->tanggal_selesai)->translatedFormat('d M Y') ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Tidak ada peserta yang diterima saat ini.</p>
            @endif
        </div>

        {{-- Tab Artikel --}}
        <div id="artikel" class="tab-content d-none">
            <h4>Artikel Informasi Umum</h4>
            <div class="row">
                @foreach($artikels as $artikel)
                    <div class="col-md-6 mb-4">
                        <a href="{{ route('artikel.index', $artikel->id) }}" class="text-decoration-none text-dark">
                            <div class="d-flex border border-2 rounded-3 p-2 hover-border">
                                <div class="me-3" style="width: 100px; height: 70px; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="thumbnail"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $artikel->judul }}</h6>
                                    <small class="text-muted d-block mb-1">
                                        {{ $artikel->created_at->format('d M Y') }}
                                    </small>
                                    <span class="text-primary small fw-semibold">Baca selengkapnya →</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tab Alur --}}
        <div id="alur" class="tab-content d-none">
            <h4 class="mb-4">Alur Pendaftaran</h4>
            <div class="timeline">
                <div class="timeline-item left"><div class="timeline-content"><h5>Registrasi akun di website</h5></div></div>
                <div class="timeline-item right"><div class="timeline-content"><h5>Login</h5></div></div>
                <div class="timeline-item left"><div class="timeline-content"><h5>Mengisi Biodata</h5></div></div>
                <div class="timeline-item right"><div class="timeline-content"><h5>Mengisi Form Pendaftaran & Upload Surat Pengantar/Proposal</h5></div></div>
                <div class="timeline-item left"><div class="timeline-content"><h5>Menunggu Disetujui</h5></div></div>
            </div>

         <!-- Bagian Persyaratan -->
        <h4 class="mt-5 mb-3">Persyaratan</h4>
            <li class="list-group-item">Mahasiswa/siswa aktif di semua jurusan</li>
            <li class="list-group-item">Mengisi form Pendaftaran</li>
        </ul>

        <!-- Tagar -->
        <div class="mt-3">
            <span class="badge bg-primary">#internship</span>
            <span class="badge bg-success">#magang</span>
            <span class="badge bg-info text-dark">#PKL</span>
        </div>
        <br>
        </div>
    </div>

    @if($kuotaPenuh)
    <div class="modal fade" id="kuotaPenuhModal" tabindex="-1" aria-labelledby="kuotaPenuhLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="kuotaPenuhLabel">Kuota Magang Penuh</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Maaf kuota magang saat ini penuh sampai bulan {{ $lastTanggalSelesai }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Scripts --}}
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            var modalKuota = new bootstrap.Modal(document.getElementById('kuotaPenuhModal'));
            modalKuota.show();
        });

        function showTab(tabId) {
            const tabs = ['peserta', 'artikel', 'alur'];
            tabs.forEach(id => document.getElementById(id).classList.add('d-none'));
            document.getElementById(tabId).classList.remove('d-none');

            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

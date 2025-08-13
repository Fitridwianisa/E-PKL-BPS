<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #002B6B;
        }

        .artikel-thumbnail {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .artikel-list-item {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .artikel-list-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .active-article {
            background-color: #e9ecef;
        }

        .scrollable-list {
            max-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    @include('layouts.header')

    <div class="container my-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a>Artikel</a></li>
                </ol>
            </nav>

            {{-- KIRI: Isi Artikel --}}
            <div class="col-lg-8 pe-lg-5 mb-4 mb-lg-0">
                @php
                    $current = $artikelUtama->firstWhere('id', request()->route('id')) ?? $artikelUtama->first();
                @endphp

                @if($current)
                    <h4 class="text-primary fw-bold mb-3">{{ $current->judul }}</h4>
                    <img src="{{ asset('storage/' . $current->gambar) }}" alt="Gambar artikel" class="artikel-thumbnail mb-3">
                    <span class="badge bg-primary mb-2">{{ $current->kategori ?? 'Umum' }}</span>
                    <div class="text-muted">
                        {!! $current->konten !!}
                    </div>
                @else
                    <p class="text-muted">Artikel tidak ditemukan.</p>
                @endif
            </div>

            {{-- KANAN: Artikel Lainnya (Grid View) --}}
            <div class="col-lg-4 scrollable-list border-start ps-lg-4">
                <h5 class="mb-4 text-primary fw-bold">Artikel Lainnya</h5>
                <div class="row">
                    @foreach($artikels as $artikel)
                        <div class="col-12 mb-3">
                            <a href="{{ route('artikel.index', $artikel->id) }}" class="text-decoration-none text-dark">
                                <div class="d-flex border border-2 border-transparent rounded-3 p-2 hover-border transition">
                                    {{-- Thumbnail --}}
                                    <div class="me-3" style="width: 100px; height: 70px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>

                                    {{-- Konten --}}
                                    <div>
                                        <span class="badge bg-primary mb-1">{{ $artikel->kategori ?? 'Umum' }}</span>
                                        <h6 class="mb-1 fw-semibold">{{ $artikel->judul }}</h6>
                                        <small class="text-muted d-block mb-1">{{ $artikel->penulis ?? 'Admin' }}</small>
                                        <span class="text-primary small fw-semibold">Baca selengkapnya →</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

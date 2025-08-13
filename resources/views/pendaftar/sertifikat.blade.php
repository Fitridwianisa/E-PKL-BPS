@extends('layouts.app')

@section('title', 'Sertifikat')

@section('content')
<div class="container mt-5">

    @if($file_sertifikat)
        {{-- Sertifikat tersedia --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-primary" style="font-size: 2rem;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="fw-semibold mb-1">Selamat, sertifikatmu sudah tersedia!</p>
                </div>
                <a href="{{ asset('storage/' . $file_sertifikat) }}" target="_blank" class="btn btn-outline-primary me-2">
                    Preview Sertifikat
                </a>
                <a href="{{ asset('storage/' . $file_sertifikat) }}" download class="btn btn-dark">
                    Download Sertifikat
                </a>
            </div>
        </div>
    @else
        {{-- Sertifikat belum tersedia --}}
        <div class="alert alert-warning text-center">
            <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
            <h5 class="mt-2">Sertifikat belum tersedia</h5>
            <p class="mb-0">Sertifikat akan tersedia setelah diunggah oleh admin.</p>
        </div>
    @endif


</div>
@endsection

@section('scripts')
<script>
    function toggleSertifikat() {
        const preview = document.getElementById('sertifikat-preview');
        preview.classList.toggle('d-none');
        preview.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection

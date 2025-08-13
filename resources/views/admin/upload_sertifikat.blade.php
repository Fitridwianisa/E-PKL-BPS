@extends('layouts.app')

@section('title', 'Upload Sertifikat')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold mb-4">Upload Sertifikat</h4>

    {{-- Form Upload Sertifikat PDF --}}
    <form action="{{ route('admin.upload_sertifikat', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file_sertifikat" class="form-label">Pilih File Sertifikat (PDF)</label>
            <input 
                type="file" 
                name="file_sertifikat" 
                id="file_sertifikat" 
                class="form-control" 
                accept="application/pdf" 
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Unggah Sertifikat</button>
    </form>

    <hr>

    {{-- Tombol Preview Sertifikat --}}
    <<hr>

    {{-- Tombol Preview Sertifikat --}}
    <a href="{{ route('sertifikat.preview') }}" target="_blank" class="btn btn-outline-primary me-2">
        Preview Sertifikat
    </a>

    {{-- Tombol Download Sertifikat --}}
    <a href="{{ route('sertifikat.download') }}" class="btn btn-dark">
        Download Sertifikat
    </a>


    {{-- Area Preview Sertifikat --}}
    <div id="sertifikat-preview" class="text-center d-none mt-3">
        <div class="border rounded shadow-sm p-3 bg-white">
            <img 
                src="{{ asset('public/tamplate/tamplate_sertifikat.pdf') }}" 
                class="img-fluid mb-3" 
                alt="Sertifikat Template" 
                style="max-width: 800px;"
            >

            {{-- Informasi dinamis --}}
        </div>
    </div>
</div>
@endsection

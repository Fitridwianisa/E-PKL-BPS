@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Dokumen -->
        <div class="col-md-6 mb-4 text-center">
            <embed src="{{ asset('storage/' . $pendaftaran->surat_pengantar) }}" type="application/pdf" width="100%" height="500px" />
        </div>

        <!-- Detail Pelamar -->
        <div class="col-md-6">
            <h5 class="mb-3"><strong>{{ strtoupper($pendaftaran->user->name) }}</strong></h5>
            <p class="text-muted">{{ $pendaftaran->user->biodata->asal_instansi ?? '-' }} / {{ $pendaftaran->user->biodata->jurusan ?? '-' }}</p>

            <table class="table table-borderless">
                <tr>
                    <th>Nama</th>
                    <td>{{ $pendaftaran->user->nama }}</td>
                </tr>
                <tr>
                    <th>Instansi</th>
                    <td>{{ $pendaftaran->user->biodata->instansi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <td>{{ $pendaftaran->user->biodata->jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. Whatsapp</th>
                    <td>{{ $pendaftaran->user->biodata->no_wa ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>
                        <form action="{{ route('admin.pendaftaran.konfirmasi', $pendaftaran->id) }}" method="POST" onsubmit="return confirmKonfirmasi(this)">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select" id="statusSelect" required>
                                <option value="">Konfirmasi penerimaan</option>
                                <option value="diterima" {{ $pendaftaran->status === 'diterima' ? 'selected' : '' }}>Terima</option>
                                <option value="ditolak" {{ $pendaftaran->status === 'ditolak' ? 'selected' : '' }}>Tolak</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Kirim</button>
                        </form>
                    </td>
                </tr>

                @if($pendaftaran->status === 'diterima')
                <tr>
                    <th>Unggah Surat Balasan</th>
                    <td>
                        @foreach($pendaftaran->suratBalasans as $sb)
                            <a href="{{ asset('storage/' . $sb->file) }}" target="_blank">Lihat Surat Balasan</a><br>
                        @endforeach

                        <form action="{{ route('admin.suratbalasan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $pendaftaran->user_id }}">
                            <input type="file" name="file" class="form-control mt-2 mb-2" required>
                            <button class="btn btn-primary btn-sm">Unggah</button>
                        </form>
                    </td>
                </tr>
                @endif

            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmKonfirmasi(form) {
        event.preventDefault();

        const nama = @json($pendaftaran->user->name);
        const status = form.querySelector('select[name="status"]').value;

        if (!status) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih status dulu!',
                text: 'Silakan pilih apakah ingin menerima atau menolak.',
            });
            return false;
        }

        const actionText = status === 'diterima' ? 'menerima' : 'menolak';

        Swal.fire({
            title: `Yakin ingin ${actionText} ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

        return false;
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 3000,
        showConfirmButton: false
    });
    @endif
</script>
@endpush



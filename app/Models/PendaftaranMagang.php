<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranMagang extends Model
{
    protected $table = 'pendaftaran_magang';
    protected $fillable = [
        'user_id', 'surat_pengantar', 'proposal', 'bagian_penempatan', 
        'jenis_magang', 'tanggal_mulai', 'tanggal_selesai', 
        'bersedia_ditempatkan_lain', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function biodata()
    {
        return $this->belongsTo(\App\Models\BiodataPeserta::class, 'user_id', 'user_id');
    }

    public function suratBalasans()
    {
        return $this->hasMany(SuratBalasan::class, 'user_id', 'user_id');
    }

}
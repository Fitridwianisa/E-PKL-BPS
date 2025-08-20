<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataPeserta extends Model
{
    protected $table = 'biodata_peserta';
    protected $fillable = [
        'user_id', 'nim_nis', 'jurusan', 'no_wa', 'foto', 'nama', 'instansi', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
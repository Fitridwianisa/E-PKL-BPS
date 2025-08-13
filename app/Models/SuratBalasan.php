<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBalasan extends Model
{
    protected $table = 'surat_balasan';

    protected $fillable = ['user_id', 'file'];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranMagang::class, 'user_id');
    }
}


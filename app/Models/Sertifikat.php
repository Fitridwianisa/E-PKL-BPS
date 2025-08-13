<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nomor_sertifikat', 'file_path'];

    // Relasi ke user (jika dibutuhkan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

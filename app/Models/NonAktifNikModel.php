<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NonAktifNikModel extends Model
{
    use HasFactory;
    
    protected $table = 'nonaktif_nik';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'user_id',
        'surat_permohonan',
        'status_aktivasi_nik'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createNonAktifNik(array $data) {
        $nonaktifNik = self::create($data);

        return $nonaktifNik;
    }

    public static function approveNonAktifNik(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_aktivasi_nik' => true
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($nonaktif_nik) {
            $nonaktif_nik->id = Str::uuid();
        });
    }
}


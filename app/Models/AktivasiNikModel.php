<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AktivasiNikModel extends Model
{
    use HasFactory;

    protected $table = 'aktivasi_nik';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'user_id',
        'surat_keterangan_aktif',
        'scan_bpjs',
        'scan_ktp',
        'sertifikat_brevet',
        'status_aktivasi_nik',
        'komentar'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createAktivasiNik(array $data) {
        $aktivasiNik = self::create($data);

        return $aktivasiNik;
    }

    public static function approveAktivasiNik(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_aktivasi_nik' => true,
                'komentar' => null
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($aktivasi_nik) {
            $aktivasi_nik->id = Str::uuid();
        });
    }
}



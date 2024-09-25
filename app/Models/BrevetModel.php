<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BrevetModel extends Model
{
    use HasFactory;

    protected $table = 'brevets';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'user_id',
        'nama',
        'mitra',
        'brevet',
        'surat_keterangan_aktif',
        'bpjs',
        'sertifikat_brevet',
        'status_brevet',
        'keterangan',
        'upload_sertifikat'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createBrevet(array $data) {
        $createBrevet = self::create($data);

        return $createBrevet;
    }

    public static function approveBrevet(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_brevet' => true,
                'keterangan' => null // Ensure the comment is reset on approval
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($brevets) {
            $brevets->id = Str::uuid();
        });
    }
}

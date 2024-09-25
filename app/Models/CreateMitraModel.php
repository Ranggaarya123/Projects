<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateMitraModel extends Model
{
    use HasFactory;

    protected $table = 'create_mitra';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'user_id',
        'username',
        'khs_mitra',
        'surat_keterangan_aktif',
        'scan_bpjs',
        'scan_ktp',
        'foto_mitra',
        'excelcreate_nikmitra',
        'status_aktivasi',
        'komentar'
    ];

    public function user () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function createCreateMitra (array $data) {
        $createMitra = self::create($data);

        return $createMitra;
    }

    public static function approveCreateMitra (string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_aktivasi' => true
            ]);
        }

        return $data;
    }

    public static function boot () {
        parent::boot();

        static::creating(function ($create_mitra) {
            $create_mitra->id = Str::uuid();
        });
    }
}

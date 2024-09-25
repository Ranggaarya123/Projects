<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MutasiModel extends Model
{
    use HasFactory;

    protected $table = 'mutasis';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];

    protected $fillable = [
        'user_id',
        'mutasi_type',
        'surat_keterangan_aktif',
        'scan_ktp',
        'brevet',
        'surat_pakelaring',
        'komentar'
    ];

    public function user () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function createMutasi (array $data) {
        $createMutasi = self::create($data);

        return $createMutasi;
    }

    public static function approveMutasi (string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_mutasi' => true
            ]);
        }

        return $data;
    }

    public static function boot () {
        parent::boot();

        static::creating(function ($mutasis) {
            $mutasis->id = Str::uuid();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MitraManajemen extends Model
{
    use HasFactory;

    protected $table = 'mitra_manajemen';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'user_id',
        'username',
        'witel',
        'alokasi',
        'mitra',
        'craft',
        'sto',
        'wh',
        'status_aktivasi_nik',
        'status_brevet',
        'status_tactical',
        'status_labor',
        'status_myi',
        'status_scmt'
    ];

    public function user () {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'id');
    }

    public static function createMitraManajemen (array $data) {
        $createMitraManajemen = self::create($data);

        return $createMitraManajemen;
    }

    public function aktivasiNik()
    {
        return $this->hasMany(AktivasiNikModel::class, 'user_id', 'user_id');
    }

    public function nonAktifNik()
    {
        return $this->hasMany(NonAktifNikModel::class, 'user_id', 'user_id');
    }

    public static function boot () {
        parent::boot();

        static::creating(function ($mitra_manajemen) {
            $mitra_manajemen->id = Str::uuid();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PindahWHModel extends Model
{
    use HasFactory;

    protected $table = 'pindah_wh';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'sto_sebelum',
        'kode_wh_sebelum',
        'sto_tujuan',
        'kode_wh_tujuan',
        'status_pindah_wh',
        'komentar' // Add this line
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createPindahWH(array $data) {
        $pindahWH = self::create($data);

        return $pindahWH;
    }

    public static function approvePindahWH(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_pindah_wh' => true,
                'komentar' => null // Ensure the comment is reset on approval
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($pindah_wh) {
            $pindah_wh->id = Str::uuid();
        });
    }
}

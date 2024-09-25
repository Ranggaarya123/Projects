<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ValidasiTacticalModel extends Model
{
    use HasFactory;

    protected $table = 'validasi_tactical';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'nama',
        'user_id',
        'capture_tactical',
        'status_validasi',
        'komentar'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createValidasiTactical(array $data) {
        $createValidasiTactical = self::create($data);

        return $createValidasiTactical;
    }

    public static function approveValidasiTactical(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_validasi' => true,
                'komentar' => null
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($validasi_tactical) {
            $validasi_tactical->id = Str::uuid();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateAktivasiMYISCMTModel extends Model
{
    use HasFactory;

    protected $table = 'create_aktivasi_myi_scmt';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string'
    ];
    protected $fillable = [
        'myiscmt_type',
        'username',
        'user_id',
        'email',
        'id_tele',
        'no_hp',
        'sto',
        'kode_wh',
        'capture_hcmbot',
        'capture_tactical',
        'status_myi',
        'komentar'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createCreateAktivasiMYISCMT(array $data) {
        $createCreateAktivasiMYISCMT = self::create($data);

        return $createCreateAktivasiMYISCMT;
    }

    public static function approveCreateAktivasiMYISCMT(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_myi' => true,
                'komentar' => null
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($create_aktivasi_myi_scmt) {
            $create_aktivasi_myi_scmt->id = Str::uuid();
        });
    }
}

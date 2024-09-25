<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DuplicateWHModel extends Model
{
    use HasFactory;

    protected $table = 'duplicate_wh';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'sto',
        'kode_wh',
        'status_duplicate',
        'komentar' // Add this line
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function mitraManajemen()
    {
        return $this->belongsTo(MitraManajemen::class, 'user_id', 'user_id');
    }

    public static function createDuplicateWH(array $data) {
        $duplicateWH = self::create($data);

        return $duplicateWH;
    }

    public static function approveDuplicateWH(string $id) {
        $data = self::find($id);

        if ($data) {
            $data->update([
                'status_duplicate' => true,
                'komentar' => null // Ensure the comment is reset on approval
            ]);
        }

        return $data;
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($duplicate_wh) {
            $duplicate_wh->id = Str::uuid();
        });
    }
}

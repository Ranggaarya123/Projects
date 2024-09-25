<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'telegram_id',
        'role',
    ];
    protected $hidden = [
        'password',
    ];

    public static function getUserByUsername (string $username) {
        $user = self::where('username', $username)->first();

        return $user;
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'password' => 'hashed',
        ];
    }

    public function brevets()
    {
        return $this->hasMany(BrevetModel::class);
    }
    public function mitra_manajemen()
    {
        return $this->hasMany(MitraManajemen::class);
    }
}

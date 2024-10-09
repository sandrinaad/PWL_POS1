<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi Authenticable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_at', 'updated_at'];
    protected $hidden = ['password']; //jangan ditampilkan saat select
    protected $casts = ['password'=>'hashed']; //casting password agar otomatis dihash

    //Relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //Mendapatkan nama role
    public function getRolename(): string {
        return $this->level->level_name;
    }

    //Cek apakah user memiliki role tertentu
    public function hasRole(): bool {
        return $this->level->level_kode == $role;
    }
}
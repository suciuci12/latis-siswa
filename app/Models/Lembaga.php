<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lembaga extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}

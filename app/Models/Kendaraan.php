<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Kendaraan extends Eloquent
{

    use HasFactory;
    protected $collection = "kendaraans";
    protected $fillable = ["tahun_keluaran", "warna", "harga"];
    protected $connection = 'mongodb';

    public function mobil()
    {
        return $this->hasOne(Mobil::class);
    }

    public function motor()
    {
        return $this->hasOne(Motor::class);
    }
}

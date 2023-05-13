<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Mobil extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $collection = "mobils";
    protected $fillable = ["mesin", "kapasitas_penumpang", "tipe"];
}

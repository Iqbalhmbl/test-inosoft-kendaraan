<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Motor extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = "motors";
    protected $fillable = ["mesin", "tipe_suspensi", "tipe_transmisi"];
}

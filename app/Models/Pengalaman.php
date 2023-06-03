<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function DataPmi()
    {
        return $this->hasMany(DataPmi::class);
    }
}

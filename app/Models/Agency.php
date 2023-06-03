<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Agency()
    {
        return $this->belongsTo(Agency::class);
        return $this->hasMany(Agency::class);
    }
    public function BukuKas()
    {
        return $this->belongsTo(BukuKas::class);
        return $this->hasMany(BukuKas::class);
    }
    public function DataPmi()
    {
        // return $this->belongsTo(DataPmi::class);
        return $this->hasMany(DataPmi::class);
    }
    public function Kantor()
    {
        return $this->belongsTo(Kantor::class);
        return $this->hasMany(Kantor::class);
    }
    public function Keluar()
    {
        return $this->belongsTo(Keluar::class);
        return $this->hasMany(Keluar::class);
    }
    public function Marketing()
    {
        return $this->belongsTo(Marketing::class);
        return $this->hasMany(Marketing::class);
    }
    public function Masuk()
    {
        return $this->belongsTo(Masuk::class);
        return $this->hasMany(Masuk::class);
    }
    public function Pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
        return $this->hasMany(Pendaftaran::class);
    }
    public function Pengalaman()
    {
        return $this->belongsTo(Pengalaman::class);
        return $this->hasMany(Pengalaman::class);
    }
    public function PetugasLapangan()
    {
        return $this->belongsTo(PetugasLapangan::class);
        return $this->hasMany(PetugasLapangan::class);
    }
    public function Status()
    {
        return $this->belongsTo(Status::class);
        return $this->hasMany(Status::class);
    }
    public function Tujuan()
    {
        return $this->belongsTo(Tujuan::class);
        return $this->hasMany(Tujuan::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
        return $this->hasMany(User::class);
    }
}

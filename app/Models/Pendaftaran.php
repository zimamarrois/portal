<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $fillable = [
    //     'nama',
    //     'nomor_ktp',
    //     'nomor_kk',
    //     'nomor_telp',
    //     'nama_wali',
    //     'nomor_telp_wali',
    //     'file_ktp',
    //     'file_ktp_wali',
    //     'file_kk',
    //     'file_akta_lahir',
    //     'file_surat_nikah',
    //     'file_surat_ijin',
    //     'file_ijazah',
    //     'file_tambahan',
    //     'data_lengkap',
    //     'proses',
    //     'alamat',
    //     'rtrw',
    //     'province_id',
    //     'regency_id',
    //     'district_id',
    //     'village_id',
    // ];
    protected $casts = [
        'file_ktp' => 'array',
    ];
    
    public function DataPmi()
    {
        return $this->hasMany(DataPmi::class);
    }
    public function Kantor()
    {
        return $this->belongsTo(Kantor::class);
    }
    public function PetugasLapangan()
    {
        return $this->belongsTo(PetugasLapangan::class);
    }
    public function Province()
    {
        return $this->belongsTo(Province::class);
        return $this->hasMany(Province::class);
    }
    public function Regency()
    {
        return $this->belongsTo(Regency::class);
        return $this->hasMany(Regency::class);
    }
    public function District()
    {
        return $this->belongsTo(District::class);
        return $this->hasMany(District::class);
    }
    public function Village()
    {
        return $this->belongsTo(Village::class);
        return $this->hasMany(Village::class);
    }
}
 
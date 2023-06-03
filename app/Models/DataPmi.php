<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPmi extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $fillable = [
    
    //             'status_update_id',
    //             'pendaftaran_id',
    //             'kantor_id',
    //             'negara_tujuan_id',
    //             'pengalaman_id',
    //             'petugas_lapangan_id',
    //             'marketing_id',
    //             'agency_id',

    //             'pra_medical',
    //             'tanggal_pra_medical',
    //             'file_pra_medical',
            

    //             'no_id_pmi',
    //             'tanggal_no_id_pmi',
    //             'file_no_id_pmi',
            
                
    //             'pra_bpjs',
    //             'tanggal_pra_bpjs',
    //             'file_pra_bpjs',
            
                
    //             'rekom_perpen',
    //             'tanggal_rekom_perpen',
    //             'file_rekom_perpen',

    //             'medical_full',
    //             'tanggal_medical_full',
    //             'file_medical_full',
            

    //             'blk',
    //             'tanggal_blk',
    //             'file_blk',
            

    //             'validasi_paspor',
    //             'tanggal_validasi_paspor',
    //             'file_validasi_paspor',
            
                
    //             'ujk',
    //             'tanggal_ujk',
    //             'file_ujk',
            
                
    //             'job',
    //             'tanggal_job',
    //             'file_job',

    //             'ec',
    //             'tanggal_ec',
    //             'file_ec',
           
                
    //             'visa',
    //             'tanggal_visa',
    //             'file_visa',
            
                
    //             'bpjs_purna',
    //             'tanggal_bpjs_purna',
    //             'file_bpjs_purna',
            
                
    //             'ktkln',
    //             'tanggal_ktkln',
    //             'file_ktkln',

    //             'terbang',
    //             'tanggal_terbang',
    //             'file_terbang',
            
                
    //             'invoice_toyo',
    //             'tanggal_ invoice_toyo',
    //             'file_invoice_toyo',
            
                
    //             'invoice_agency',
    //             'tanggal_invoice_agency',
    //             'file_invoice_agency',
    //             'medical_check',
                
    //             'telp_siapkerja',
    //             'email_siapkerja',
    //             'password_siapkerja',
    //             'siapkerja',
    //             'file_pp',
    //             'verdata',
    //             'verpp',
    //             'tglsiapkerja',

    // ];

// KONEKSI-----------------------------------------------------------
public function Pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
    public function Tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }
    public function StatusUpdate()
    {
        return $this->belongsTo(StatusUpdate::class);
    }
    public function Marketing()
    {
        return $this->belongsTo(Marketing::class);
    }
    public function PetugasLapangan()
    {
        return $this->belongsTo(PetugasLapangan::class);
    }
    public function Agency()
    {
        return $this->belongsTo(Agency::class);
    }
    public function Kantor()
    {
        return $this->belongsTo(Kantor::class);
    }
    public function Pengalaman()
    {
        return $this->belongsTo(Pengalaman::class);
    }
    public function Regency()
    {
        return $this->belongsTo(Regency::class);
        return $this->hasMany(Regency::class);
    }
}

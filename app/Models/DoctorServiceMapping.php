<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorServiceMapping extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id','clinic_id','service_id','charges','status','created_by'];
    protected $casts = [
        'doctor_id' => 'integer',
        'service_id' => 'integer',
        'charges' => 'double',
        'clinic_id'=>'integer'
    ];

    public function doctors()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','doctor_id')->with('user');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinics::class,'clinic_id','id');

    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}

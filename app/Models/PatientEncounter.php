<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientEncounter extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'patient_encounters';
    
    protected $fillable = ['encounter_date','user_id','clinic_id','doctor_id','vendor_id','appointment_id','encounter_template_id','description','status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinics::class, 'clinic_id','id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id','id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id','id');
    }

    public function medicalHistroy()
    {
        return $this->hasmany(EncouterMedicalHistroy::class, 'encounter_id','id');
    }

    public function prescriptions()
    {
        return $this->hasmany(EncounterPrescription::class, 'encounter_id','id');
    }
    public function EncounterOtherDetails(){

        return $this->hasone(EncounterOtherDetails::class, 'encounter_id','id');
        
    }
    public function medicalReport(){

        return $this->hasMany(EncounterMedicalReport::class, 'encounter_id','id');
        
    }
    public function diseases()
    {
        return $this->hasmany(EncounterMedicalProblems::class, 'encounter_id','id');
    }
    
}

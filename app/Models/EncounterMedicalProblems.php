<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EncounterMedicalProblems extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'encounter_medical_problems';
    
    protected $fillable = ['encounter_id','user_id','problem','observation','note','created_by'];
 
    protected static function newFactory(): EncounterPrescriptionFactory
    {
        //return EncounterPrescriptionFactory::new();
    }

    public function encounter()
    {
        return $this->belongsTo(PatientEncounter::class)->with('clinic','doctor');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EncounterPrescription extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'encounter_prescription';
    
    protected $fillable = ['encounter_id','user_id','name','frequency','duration','instruction'];
 
    protected static function newFactory(): EncounterPrescriptionFactory
    {
        //return EncounterPrescriptionFactory::new();
    }

    public function encounter()
    {
        return $this->belongsTo(PatientEncounter::class)->with('clinic','doctor');
    }
}

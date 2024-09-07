<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EncounterMedicalReport extends Model
{
    use HasFactory;
    use SoftDeletes;
   
     protected $table = 'encounter_medical_report';
    
     protected $fillable = ['encounter_id','user_id','name','date','doc_files'];

     

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    
}

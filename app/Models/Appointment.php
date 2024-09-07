<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'appointments';
     protected $fillable = ['status', 'start_date_time','user_id','clinic_id','doctor_id','departments_id','appointment_extra_info','room','appointment_date','appointment_time','service_id','total_amount','service_amount','service_price','duration'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinics extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'clinic';
    protected $fillable = ['slug','name','email','time_slot','system_service_category','description', 'address', 'city','state', 'country', 'pincode','vendor_id', 'contact_number', 'latitude','longitude','status'];

    
}

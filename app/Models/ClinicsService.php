<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicsService extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'clinics_services';
    protected $fillable = ['system_service_id','name','description','type','is_video_consultancy','charges','category_id','subcategory_id','vendor_id','duration_min','time_slot','discount','discount_value','discount_type','status'];

    
}

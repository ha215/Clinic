<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;
   

    protected $table = 'doctors';
    protected $fillable = ['doctor_id','experience','signature','vendor_id'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}

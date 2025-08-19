<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;
         protected $fillable = [ 
    'patient_id',
    'doctor_id',
    'branch_id',
    'date',
     'fee',
    //'phone',        // ✅ Add this
    'diagnosis',
    'note',
];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
 {
    return $this->belongsTo(Doctor::class);
}
}



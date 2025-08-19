<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors'; 

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
    ];

    // ───────────────────────────────
    // Relationships
    // ───────────────────────────────

    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function performances()
    {
        return $this->hasMany(DoctorPerformance::class);
    }

    public function checkups()
    {
        return $this->hasMany(Checkup::class, 'doctor_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'doctor_id');
    }

    public function treatmentSessions()
    {
        return $this->hasMany(TreatmentSession::class, 'doctor_id');
    }

    public function completedSessions()
    {
        // Doctor ne jo sessions complete kiye (via SessionTime)
        return $this->hasMany(SessionTime::class, 'completed_by_doctor_id');
    }
}

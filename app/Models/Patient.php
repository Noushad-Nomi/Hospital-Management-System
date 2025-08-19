<?php

namespace App\Models;
use App\Models\Patient;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
     protected $fillable = [ 
    'name',
    'gender',
    'guardian_name',
    'age',
    'phone',
    'address',
    'branch_id',
];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}
public function invoices()
{
    return $this->hasMany(Invoice::class);
}
}

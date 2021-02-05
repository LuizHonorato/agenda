<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'profile_pic', 'is_active', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

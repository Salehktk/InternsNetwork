<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function coachData()
    {
        
        return $this->hasone(CoachData::class);
    }
    public function coachResumes()
    {
        return $this->hasMany(CoachResume::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceGooglesheet extends Model
{
    use HasFactory;

    protected $table = 'service_googlesheets';

    protected $guarded = [];
    
    public function coaches()
    {
        return $this->belongsTo(CoachGooglesheet::class, 'coach_service', 'service_id', 'coach_id')->withTimestamps();
    }
}

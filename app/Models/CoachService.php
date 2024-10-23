<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachService extends Model
{
    use HasFactory;

    protected $table = 'coach_service';


    public function coaches()
    {
        return $this->belongsTo(CoachGooglesheet::class, 'coach_id');
    }

    public function serviceBelong()
    {
        return $this->belongsTo(ServiceGooglesheet::class, 'service_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachGooglesheet extends Model
{
    use HasFactory;

    protected $table = 'coach_googlesheets';

    protected $guarded = [];
    
    public function services()
    {
        return $this->HasMany(CoachService::class,  'coach_id' );
    }
}

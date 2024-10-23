<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachResume extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function adminSetup()
    {
        return $this->belongsTo(AdminSetup::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function admin_setup()
    {
        return $this->belongsTo(AdminSetup::class);
    }
}

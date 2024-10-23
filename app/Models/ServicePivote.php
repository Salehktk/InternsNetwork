<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePivote extends Model
{
    use HasFactory;


    protected $table = 'service_pivotes';


    public function AllsheetService()
    {
        return $this->belongsTo(AllService::class, 'all_service_id');
    }

    public function serviceBelongtopivot()
    {
        return $this->belongsTo(ServiceGooglesheet::class, 'service_googlesheet_id');
    }

    
}

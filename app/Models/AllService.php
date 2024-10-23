<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AllService extends Model
{
    use HasFactory;

    protected $table = 'all_services';

    public function allservice()
    {
        return $this->hasMany(ServicePivote::class, 'all_service_id');

    }
}

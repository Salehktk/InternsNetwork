<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class BillingInfo extends Model
{
    use Billable;
    use HasFactory;

    protected $guarded = [];


   public function user() 
    {
        return $this->belongsTo(User::class);
   }

}

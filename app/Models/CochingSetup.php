<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CochingSetup extends Model
{
    use HasFactory;
    
    protected $guarded=[];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cochingSetup) {
            $cochingSetup->identifier = self::generateUniqueIdentifier($cochingSetup->client);
        });
    }

    private static function generateUniqueIdentifier($clientName)
    {
        $datePart = now()->format('ymd');

        $count = CochingSetup::whereDate('created_at', now()->toDateString())->count() + 1;
        $sequenceNumber = sprintf('%02d', $count);

        $identifier = $datePart . $sequenceNumber;
    
        return $identifier;
    }








    // private static function generateUniqueIdentifier($clientName)
    // {
    //     // Explode the full name into an array of words
    //     $nameParts = explode(' ', $clientName);

    //     if (count($nameParts) < 2) {
           
    //         return null;
    //     }    
      
    //     $firstNameInitial = strtoupper(substr($nameParts[0], 0, 2));
    
    //     $secondNameInitial = strtoupper(substr($nameParts[1], 0, 1));

    //     $initials = $firstNameInitial . $secondNameInitial;

    //     $datePart = now()->format('ymd');

    //     $count = CochingSetup::where('client', $clientName)->count() + 1;

    //     $identifier = $datePart . $initials . sprintf('%02d', $count);
    
    //     return $identifier;
    // }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingPrice extends Model
{
    protected $fillable = [
        'days',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'days' => 'integer',
            'price' => 'integer',
        ];
    }
}

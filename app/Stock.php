<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product', 'stock_quantity','adjustment', 'location_id',
    ];
}

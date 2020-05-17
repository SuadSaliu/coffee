<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    /**
     * setup variable mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'table_name',
        'customer_id',
        'order_time',
    ];

}

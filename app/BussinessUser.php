<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BussinessUser extends Model
{
    protected $table = 'bussiness_user';
    protected $primaryKey = 'user_id';

    /**
     * rules data validation.
     *
     * @var array
     */
    public static $rules = [
        'user_id'        => 'required',
        'bussiness_id'   => 'required',
        'bussiness_role' => 'required'
    ];
    
    /**
     * setup variable mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bussiness_id', 'bussiness_role',
    ];
}

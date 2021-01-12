<?php

namespace App\Models;

use App\Utils\MasksUtil;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'neighborhood',
        'zip_code',
        'city',
        'federative_unit',
        'citizen_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    function setZipCodeAttribute($value){
        $this->attributes['zip_code'] = MasksUtil::unmask($value);
    }
}

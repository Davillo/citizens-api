<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{

    protected $table = 'citizens';

    protected $appends = ['address'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'national_registry',
        'email',
        'phone_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function address(){
        return $this->hasOne(Address::class, 'citizen_id');
    }

    public function getAddressAttribute(){
        return $this->address()->first();
    }
}

<?php

namespace App\Models;

use App\Utils\MasksUtil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

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
        'celphone'
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

    public function setNationalRegistryAttribute($value){
        $this->attributes['national_registry'] = MasksUtil::unmask($value);
    }

    public function getNationalRegistryAttribute($value){
        return MasksUtil::mask($value, '###.###.###-##');
    }

    public function setCelphoneAttribute($value){
        $this->attributes['celphone'] = MasksUtil::unmask($value);
    }

    public function getCelphoneAttribute($value){
        return MasksUtil::mask($value, '(##) #####-####');
    }
}

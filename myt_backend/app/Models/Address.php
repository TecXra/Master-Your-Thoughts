<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [ 'address_line_1', 'address_line_2', 'city_name' ,'state', 'zip_code','addressable'];


     public function addressable()
    {
        return $this->morphTo();
    }

}

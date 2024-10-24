<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [ 'title' ];

    public function questions()
    {
    	return $this->hasMany(Question::class)->orderBy('number');
    }

    public function vRQuestions()
    {
        return $this->hasMany(VRQuestion::class)->orderBy('number');
    }


    public function vRUnitDetail()
    {
        return $this->hasOne(VRUnitDetail::class);
    }

}

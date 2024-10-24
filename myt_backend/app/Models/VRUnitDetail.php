<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VRUnitDetail extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [ 'description', 'unit_id'];

	public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

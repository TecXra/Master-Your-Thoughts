<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VRQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'video_url', 'video_thumbnail_url', 'enable_on_unit', 'unit_number', 'unit_id','number' ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function vRResponses()
    {
        return $this->hasMany(VRResponse::class);
    }
    public function vRAnswer()
    {
        return $this->hasMany(VRAnswer::class);
    }
    public function vRPhrase()
    {
        return $this->hasMany(VRPhrase::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VRPhrase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'phrase', 'v_r_question_id'];

    public function vRQuestion()
    {
        return $this->belongsTo(VRQuestion::class);
    }
    public function vRResponse()
    {
        return $this->hasOne(VRResponse::class);
    }

}

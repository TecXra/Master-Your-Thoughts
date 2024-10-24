<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VRAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'answer', 'v_r_question_id', 'tag_id' ,'label'];

    public function vRQuestion()
    {
        return $this->belongsTo(VRQuestion::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function vRResponse()
    {
        return $this->hasOne(VRResponse::class);
    }


}

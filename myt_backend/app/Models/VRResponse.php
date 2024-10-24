<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VRResponse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vRQuestion()
    {
        return $this->belongsTo(VRQuestion::class);
    }
    public function vRAnswer()
    {
        return $this->belongsTo(VRAnswer::class);
    }
    public function vRPhrase()
    {
        return $this->belongsTo(VRPhrase::class);
    }
}

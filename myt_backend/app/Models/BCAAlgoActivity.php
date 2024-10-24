<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCAAlgoActivity extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'level_id' ];

    protected $appends = ['level_name'];

    public function level() {
        return $this->belongsTo( BCALevel::class,'level_id');
    }

    public function getLevelNameAttribute()
    {
        return $this->level->name ;
    }

}

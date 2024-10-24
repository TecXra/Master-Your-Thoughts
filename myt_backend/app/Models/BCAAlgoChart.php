<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCAAlgoChart extends Model
{
    use HasFactory;

    protected $fillable = [ 'text', 'image', 'level_id', 'activities' ];



     protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if($this->id != noActivityAlgoId()){
            return config('app.url').'/storage/'.($this->image) ;
        }
        return "";

    }
}

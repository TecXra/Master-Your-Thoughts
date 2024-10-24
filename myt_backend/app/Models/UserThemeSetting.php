<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserThemeSetting extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'font_family', 'navbar_style', 'navbar_color', 'sidebar_color', 'default_theme', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

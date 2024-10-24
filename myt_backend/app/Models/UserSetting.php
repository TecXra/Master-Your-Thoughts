<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
		'slide_show_default_view',
		'slide_show_interval',
		'user_id',
        'country',
        'city',
        'state',
        'time_zone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoApiSetting extends Model
{
    use HasFactory;
    protected $table = "video_api_settings";

    protected $fillable = [
		'type',
		'client_id',
		'client_secret',
		'personal_access_token'
    ];
}

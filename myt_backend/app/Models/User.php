<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'wp_user_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'time_zone_name'
    ];

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }
    public function slideShow()
    {
        return $this->hasOne(SlideShow::class);
    }
    public function faithFuels()
    {
            return $this->hasMany(FaithFuel::class);
    }
    public function mytLogs()
    {
        return $this->morphMany(MytLog::class, 'myt_logable');
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    public function vrResponses()
    {
        return $this->hasMany(VRResponse::class);
    }
    public function userThemeSetting()
    {
        return $this->hasOne(UserThemeSetting::class);
    }
    public function isTimeZoneSettingExist()
    {
        return isset($this->userSetting->time_zone)?1:0;
    }
    public function getTimeZoneNameAttribute()
    {
        $userSettingObj = UserSetting::where('user_id', $this->id)->first();
        if ($userSettingObj->time_zone != null) {
            $timeZoneObj = TimeZone::find($userSettingObj->time_zone);
            return $timeZoneObj->time_zone;
        }
        return null;
    }
    public function getFaithFuelPointsAttribute()
    {
        $points = 0;
        foreach ($this->faithFuels as $faithFuels) {
            $points += (int)$faithFuels->points;
        }
        
        return $points;
    }
}
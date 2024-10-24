<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use App\Models\UserSetting;
use App\Models\AuthProvider;
use Illuminate\Http\Request;
use Facades\Services\CommonService;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Log;

class SocialLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }


    public function getWordPressProviderClass($provider)
    {
        switch ($provider) {
            case 'masteryourthoughts.net':
                return \Services\Socialite\MYTWordPressProvider::class;
                break;
            case 'wordpress.local':
                return \Services\Socialite\WPWordPressProvider::class;
                break;

            default:
                return null;
                break;
        }
        return null;
    }


    public function getWordPressProviderConfig($provider)
    {
        $configWP = config('services.wordpress')[$provider];
        return $configWP;

    }


    public function redirectToWordPressProvider($provider)
    {
        $provider = Socialite::buildProvider($this->getWordPressProviderClass($provider), $this->getWordPressProviderConfig($provider));
        return $provider->redirect();
    }

    public function handleWordPressProviderCallback($provider)
    {
        try{
            $provider = Socialite::buildProvider($this->getWordPressProviderClass($provider), $this->getWordPressProviderConfig($provider));
            $user = $provider->stateless()->user();


            // if ($user->user['user_login'] == 'admin')
            // {
            //     $user_type = config('MYT.user_type.admin');
            // }
            // else if ($user->user['user_login'] == 'user')
            // {
            //     $user_type = config('MYT.user_type.user');
            // }
            // Log::info(json_encode($user));
            // Log::info($user);
            $userCreated = User::firstOrCreate(
                [
                    'email'=>$user->getEmail()
                ],
                [
                    // 'name'=>$user->getName(),
                    'name'=>$user->getNickname(),
                    'wp_user_id'=>$user->getID(),
                    'user_type'=>1
                ]
            );

            $tokenResult = $userCreated->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;

            $UserSettingObj = CommonService::saveNewUserDefaultSettings($userCreated->id);

            $UserThemeSettingObj = CommonService::saveNewUserDefaultThemeSettings($userCreated->id);

            $UserLoggedInDate = CommonService::saveUserLoggedInDate($userCreated);

            $saveDefaultWallpaperObj = saveNewUserWallpaperToDraft($userCreated->id);
            // $saveDefaultWallpaperObj = WallpaperService::saveWallpaperToDraft($wallpaperData, $userCreated->id);
            // dd($saveDefaultWallpaperObj);
            // dd($UserLoggedInDate);
            // dd(redirect(env('CLIENT_BASE_URL') . '/wp-login-callback?token=' . $token));
            // return redirect(env('CLIENT_BASE_URL') . '/wp-login-callback?token=' . $token);
            return redirect(config('MYT.CLIENT_BASE_URL') . '/wp-login-callback?token=' . $token);

        }
        catch(ClientException $exception){
            return response()->json(['error'=>'Invalid Credentials'],422);
        }

    }
}




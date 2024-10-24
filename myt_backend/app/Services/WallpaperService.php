<?php 

namespace Services;

use App\Models\User;
use App\Models\Media;
use App\Models\Wallpaper;
use App\Models\UserSetting;
use App\Models\DraftWallpaper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class WallpaperService
{
    public function uploadWallpaperImage($media,$user_id)
    {        
        $wallpapers = Wallpaper::where('user_id',$user_id)->where('device_type',$media['device_type'])->get();
        if(count($wallpapers)==config('MYT.wallpaper_limit')){
            $wallpapers[0]->delete();
        }
        $file = $media['src']; // your base64 encoded
        $fileExtension = $media['ext'];
        $fileType = $media['type'];

        $file = str_replace('data:'.$fileType.'/'. $fileExtension . ';base64,', '', $file);
        $file = str_replace(' ', '+', $file);
        $fileName = Str::random(32) . '.' . $fileExtension;
        $file_path = storage_path() . '/app/public/dynamic/wallpaper/' . $fileName;
        $file_db_path = 'dynamic/wallpaper/'. $fileName;
        \File::put($file_path, base64_decode($file));

        $wallpaper = Wallpaper::create(['user_id'=>$user_id,'device_type'=>$media['device_type']]);

        $mediaObj = $wallpaper->media()->save(new Media([
            'file_path' => $file_db_path,   
            'type' => $fileType,
        ]));
        saveBootCampAnalyticLog($user_id,getTheAttractionWallBcaActivityId());
        return true;
    }

    public function getWallpapersList($type,$user_id)
    {
        $wallpapers = Wallpaper::with('media')->where('user_id',$user_id)->where('device_type',$type)->get();
        $data_set=[];
        foreach ($wallpapers as $key => $wallpaper) {
            if(isset($wallpaper->media))
            {
                $img = storage_path() . '/app/public/' . $wallpaper->media->file_path;
                $type = pathinfo($img, PATHINFO_EXTENSION);
                $data = file_get_contents($img);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $temp = [
                    'id'=>$wallpaper->id,
                    'link_url'=>$wallpaper->media->link_url,
                    'base64'=>$base64
                ];
                array_push($data_set,$temp);
            }
        }
        return $data_set;
    }

    public function deleteWallpaper($id)
    {
        $wallpaper = Wallpaper::find($id);
        $wallpaper->media()->delete();
        $wallpaper->delete();
        return true;
    }

    public function saveWallpaperToDraft($data_array, $user_id)
    {
        // return $data_array['draftData'];
        // Log::info($data_array['draftData']);

        $draftedWallpaperObj = DraftWallpaper::where('user_id',$user_id)->where('device_type',$data_array['device_type'])->first();
        
        if (isset($draftedWallpaperObj))
        {
            $draftedWallpaperObj->delete();
        }
        $draftedWallpaperObj = DraftWallpaper::create([
            'user_id'=>$user_id,
            'device_type'=>$data_array['device_type'],
            'draft_data'=>$data_array['draftData']
        ]);

        return $draftedWallpaperObj;
    }
    public function getDraftWallpaper($data_array, $user_id)
    {
        $type = $data_array['type'];
        $draftedWallpaperObj = DraftWallpaper::where('user_id',$user_id)->where('device_type',$type)->first();
        return $draftedWallpaperObj;
        // $data_set=[];
        // foreach ($wallpapers as $key => $wallpaper) {
        //     if(isset($wallpaper->media))
        //     {
        //         $img = storage_path() . '/app/public/' . $wallpaper->media->file_path;
        //         $type = pathinfo($img, PATHINFO_EXTENSION);
        //         $data = file_get_contents($img);
        //         $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        //         $temp = [
        //             'id'=>$wallpaper->id,
        //             'link_url'=>$wallpaper->media->link_url,
        //             'base64'=>$base64
        //         ];
        //         array_push($data_set,$temp);
        //     }
        // }
        // return $data_set;
    }





    
    public function getAuthUserSlideShowImages($user_id)
    {
        $slideShowObj = SlideShow::where('user_id', $user_id)->first();

        $mediaList = $slideShowObj->medias()->where('type', 'image')->get();

        // $mediaList = Media::where('mediaable_id', $user_id)->get();
        return $mediaList;
    }
    public function deleteSlideShowImage($media_id)
    {
        $mediaObj = Media::find($media_id);
        $mediaObj->delete();
        return true;
    }
    public function updateSlideShowDefaultView($default_view, $user_id)
    {
        $userSettingObj = UserSetting::where('user_id',$user_id)->first();
        
        $userSettingObj->update(['default_view'=>$default_view]);

        return $userSettingObj->default_view;
    }
    public function updateSlideShowInterval($slide_show_interval, $user_id)
    {
        $userSettingObj = UserSetting::where('user_id',$user_id)->first();
        $userSettingObj->update(['slide_show_interval'=>$slide_show_interval]);
        return $userSettingObj->slide_show_interval;
    }
    public function getAuthUserSlideShowSettings($user_id)
    {
        $userSettingObj = UserSetting::where('user_id',$user_id)->first();
        return $userSettingObj;
    }
}
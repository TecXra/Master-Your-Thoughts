<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\Media;
use Facades\Services\CommonService;
use Facades\Services\WallpaperService;
use App\Models\Instruction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WallpaperController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}
	public function getInstructionVideo(Request $request)
	{
		return CommonService::getInstructionVideo($request->video_for);
	}
	public function saveWallpaper(Request $request)
	{
		return WallpaperService::uploadWallpaperImage($request->all(), Auth::User()->id);
	}
	public function getWallpapersList(Request $request)
	{
		return WallpaperService::getWallpapersList($request->get('type'), Auth::User()->id);
	}
	public function deleteWallpaper($id)
	{
		return WallpaperService::deleteWallpaper($id);
	}
	public function saveWallpaperToDraft(Request $request)
	{
		return WallpaperService::saveWallpaperToDraft($request->all(), Auth::User()->id);
	}
	public function getDraftWallpaper(Request $request)
	{
		return WallpaperService::getDraftWallpaper($request->all(), Auth::User()->id);
	}




}
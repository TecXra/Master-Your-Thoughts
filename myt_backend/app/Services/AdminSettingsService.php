<?php

namespace Services;

use Carbon\Carbon;
use App\Models\Media;
use App\Models\MytLog;
use App\Models\Instruction;
use App\Models\VideoApiSetting;
use Illuminate\Support\Str;

class AdminSettingsService
{
	// save instructions
	public function saveInstructionData($data)
	{
		$instructionObj = Instruction::create([
			'instructions_for' => $data['instructionFor'],
			'type' => $data['videoType']
		]);
		return $instructionObj;
	}

	// save video and return path
	public function getFileDBPath($data)
	{
		if ($data['videoType'] == 'url')
		{
			$file_db_path = $data['videoDataUrl'];
		}
		if ($data['videoType'] == 'upload')
		{
			$file = $data['videoBase64Data'];
			$fileExtension = $data['videoExtension'];
			$file = str_replace('data:video/'. $fileExtension . ';base64,', '', $file);
			$file = str_replace(' ', '+', $file);
			$fileName = Str::random(32) . '.' . $fileExtension;
			$file_path = storage_path() . '/app/public/upload/' . $fileName;
			$file_db_path = 'upload/'. $fileName;
			\File::put($file_path, base64_decode($file));
		}
		return $file_db_path;
	}

	// save instruction videos
	public function saveInstructionVideo($instructionObj, $file_path)
	{
		$instructionObj->medias()->save(new Media([
			'file_path' => $file_path,
			'type' => 'video',
		]));

		return true;
	}

	// update instructions video
	public function updateInstructionVideo($instructionObj, $videoType, $file_db_path)
	{
		$instructionObj->update(['type'=>$videoType]);
		$mediaObj = $instructionObj->medias()->where('type', 'video')->first();
		$mediaObj->update(['file_path'=>$file_db_path]);
		return true;
	}

	// get video api data
	public function getVideoApiData()
	{
		return VideoApiSetting::first();
	}
}
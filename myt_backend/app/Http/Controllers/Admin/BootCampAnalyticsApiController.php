<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BCAAlgoActivity;
use App\Models\BCAAlgoChart;
use App\Models\BCALevel;
use Illuminate\Http\Request;

class BootCampAnalyticsApiController extends Controller
{


	public function getAllLevels(){
		return  BCALevel::All();
	}

	public function addNewActivityAlgo(Request $request){

		

		$activity = new BCAAlgoActivity();
        $activity->name = $request->name;
        $activity->level_id=$request->level;
        $activity->save();
        return true;  


	}

		public function addNewChartAlgo(Request $request){

		

		$activity = new BCAAlgoChart();
        $activity->text = $request->text;
        $activity->level_id=$request->level_id;
        $activity->image = $request->image;
        $activity->activities=$request->activity;
        $activity->save();
        return true;  


	}


 	public function bootCampAnalyticsActivitiesList(){
		
		return BCAAlgoActivity::All();
	
	}

	public function bootCampAnalyticsChartsList(){
		
		return BCAAlgoChart::All();
	
	}
	public function deleteBootCampAnalyticsChartById($id){


		$chart = BCAAlgoChart::find($id);
		$chart->delete();
		return true;
 

	}
	public function deleteBootCampAnalyticsActivityById($id){
		// return $id;
		$activity = BCAAlgoActivity::find($id);
		$activity->delete();
		return true;
 

	}
	public function getBootCampAnalyticsChartById($id){

		$chart = BCAAlgoChart::find($id);
		
		return $chart;
 

	}
	public function getBootCampAnalyticsActivityById($id){

		$activity = BCAAlgoActivity::find($id);
		
		return $activity;
 

	}
	public function updateActivityById(Request $request)
	{


			$activity = BCAAlgoActivity::find($request->id);
				$activity->fill([
					'name' => $request->name,
					'level_id' => $request->level
				])->save();

				return true;
	}
		public function updateChartById(Request $request)
	{
		
		$image = $request->image;
        $imageName = str_replace(' ', '-', $request->text);
        $imageName = strtolower($imageName);
        if (strpos($image, 'jpeg') !== false)
        {
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $imageName . '.' . 'jpg';
        }
        else if (strpos($image, 'png') !== false)
        {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $imageName . '.' . 'png';
        }
        else
        {
            $imageName = $imageName . '.' . 'png';
        }
        $file_path = storage_path() . '/app/public/dynamic/charts/' . $imageName;
        $file_db_path = 'dynamic/charts/'. $imageName;
        \File::put($file_path, base64_decode($image));


			$activity = BCAAlgoChart::find($request->id);
				$activity->fill([
					'text' => $request->text,
					'level_id' => $request->level_id,
					'image' => $file_db_path,
					'activities' => $request->activity
				])->save();

				return true;
	}	

}
<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuotesLog;
use App\Http\Controllers\Controller;
use App\Models\LoopingDuration;
use Carbon\Carbon;
use DateTime;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
	public function getRandomQuote()
	{
		$quoteList = Quote::all();
		if (count($quoteList) > 0)
		{
			$quote = $quoteList->random(1);
			// if($this->getQuotesLog($quote[0]->id))
			return $quote[0];
		}
		else
		{
            return null;
		}
	}
	public function getQuotesLog()
	{
        $authUser = Auth::User();
		$current_date_time = Carbon::now();
		$current_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $current_date_time);
		// ->toDateTimeString();
		// return $current_date_time;
		$previousQuoteLogs = QuotesLog::where('user_id', $authUser->id)->first();
		$looping_duration = LoopingDuration::where('type','Quotes')->first();
		$quotes_duration = $looping_duration->duration;
		// return $previousQuoteLogs;
		$quote = $this->getRandomQuote();
		$quote_id = $quote->id;

		if(isset($previousQuoteLogs))
		{
			
			$lastQuotesDateTime = $previousQuoteLogs->date_time;
			// return $lastQuotesDateTime;
			$lastQuotesDateTime = Carbon::parse($lastQuotesDateTime);
			// return $lastQuotesDateTime;
			// return $lastQuotesDateTime . ' ------- ' . $current_date_time . '-------------------';
			$differenceInminutes = $lastQuotesDateTime->diffInMinutes($current_date_time);
			// echo $differenceInminutes . ' ------ ' . $quotes_duration . '-------------------';
			if($differenceInminutes < $quotes_duration)
			{
				// return 'false';
				return Quote::find($previousQuoteLogs->quote_id);
			}
        	$previousQuoteLogs->update(['date_time'=> $current_date_time]);
        	$previousQuoteLogs->update(['quote_id'=> $quote_id]);
			return Quote::find($quote_id);
				// return 'true';
		}
		else
		{
			QuotesLog::create([
				'user_id' => $authUser->id,
				'quote_id' => $quote_id,
				'date_time' => $current_date_time,
			]);
	
			return Quote::find($quote_id);
			// return 'true';
		}
	
	}

}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\Services\WallpaperService;

class AsifTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asif:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

      

        dd(getUnitQuestionsListWithStatus(1,13));


        $deviceList = [ "desktop", "iphone", "ipad"];
      


        $user_id = 2;
        $jsonData = [
            "backgroundInfo" => [
                "image" => null,
                "color" => '#ffffff'
            ],
            "foregroundInfo" => [
                "image" => null,
                "width" => 0,
                "height" => 0,
                "left" => 0,
                "top" => 0,
            ],
            "textInfo" => [
                "content" => '<p>Here is where you can add your text.</p>',
                "color" => '#ffffff',
                "fontFamily" => 'Poppins',
                "width" => 0,
                "height" => 0,
                "left" => 0,
                "top" => 0
            ]
        ];
        for ($i=0; $i < count($deviceList); $i++) { 
            $payload = [
                "device_type" => $deviceList[$i],
                "draftData" => $jsonData
            ];
            $saveDefaultWallpaperObj = WallpaperService::saveWallpaperToDraft($payload, $user_id);
        }

        dd($saveDefaultWallpaperObj);

        dd(isUpperResponsesCompleted(1,2));
        // $inProgressUnitVideoQuestion = getInProgressUnitVideoQuestionByUserId($user_id);

        // dd($inProgressUnitVideoQuestion);
    }
}

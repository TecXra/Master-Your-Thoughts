<?php
return [

    'CLIENT_BASE_URL' => env('CLIENT_BASE_URL'),

    'user_type' => ['admin'=>0,'user'=>1],
    'user_type_name' => [
        ['id'=>0,'name'=>'Admin'],
        ['id'=>1,'name'=>'User']
    ],

    'default_view' => ['slide_show'=>0,'gallery'=>1],
    'default_view_name' => [
        ['id'=>0,'name'=>'Slide Show'],
        ['id'=>1,'name'=>'Gallery']
    ],

    'media_types' => ['image','video'],

    'media_type_list' => [
        ['id'=>0, 'name'=>'image'],
        ['id'=>1, 'name'=>'video']
    ],

    'myt_log_types'=>[
        'loggedIn_at'
    ],

    'myt_log_type'=>[
        'loggedIn_at'=>'loggedIn_at'
    ],

    'question_type' => ['practice_check'=>0, 'video_review'=>1],

    'practice_status' => ['not_started'=>0, 'in_practice'=>1],
    
    'score_tag' => ['upper_score'=>0, 'lower_score'=>1],

    'default_looping_duration' => 30, // in minutes

    'videos_enabled_unit' => 4,

    'last_unit_number' => 8,

    'base_columns_for_report_stats' => ['id','name','email','state','country'],

    'report_types' => [
        [
            'key'=>1,
            'report'=>'DateTheUserStartedTheFirstUnitStats'
        ],
        [
            'key'=>2,
            'report'=>'NumberOfPointsOfFaithAndFuelStats'
        ],
        [
            'key'=>3,
            'report'=>'UnitThatIsCurrentlyBeingWorked'
        ],
        [
            'key'=>4,
            'report'=>'DateTheUnitThatIsCurrentlyBeingWorkedStarted'
        ],
    ],
    'wallpaper_limit'=>12,

    'default_theme' => ['light'=>0,'dark'=>1],
    'default_theme_name' => [
        ['id'=>0,'name'=>'Light Mode'],
        ['id'=>1,'name'=>'Dark Mode']
    ],

    'navbar_style' => ['colored'=>0,'transparent'=>1],
    'navbar_style_name' => [
        ['id'=>0,'name'=>'Colored'],
        ['id'=>1,'name'=>'Transparent']
    ],


    'states_list' => [
        ['id'=>1,'state_name'=>'Alabama', 'postal_code'=>'AL','active'=>0],
        ['id'=>2, 'state_name'=>'Alaska', 'postal_code'=>'AK','active'=> 0],
        ['id'=>3, 'state_name'=>'Arizona', 'postal_code'=>'AZ','active'=> 0],
        ['id'=>4, 'state_name'=>'Arkansas', 'postal_code'=>'AR','active'=> 0],
        ['id'=>5, 'state_name'=>'California', 'postal_code'=>'CA','active'=> 0],
        ['id'=>6, 'state_name'=>'Colorado', 'postal_code'=>'CO','active'=> 0],
        ['id'=>7, 'state_name'=>'Connecticut', 'postal_code'=>'CT','active'=> 0],
        ['id'=>8, 'state_name'=>'Delaware', 'postal_code'=>'DE','active'=> 0],
        ['id'=>9, 'state_name'=>'District Of Columbia', 'postal_code'=>'DC','active'=> 1],
        ['id'=>10, 'state_name'=>'Florida', 'postal_code'=>'FL','active'=> 0],
        ['id'=>11, 'state_name'=>'Georgia', 'postal_code'=>'GA','active'=> 0],
        ['id'=>12, 'state_name'=>'Hawaii', 'postal_code'=>'HI','active'=> 0],
        ['id'=>13, 'state_name'=>'Idaho', 'postal_code'=>'ID','active'=> 0],
        ['id'=>14, 'state_name'=>'Illinois', 'postal_code'=>'IL','active'=> 0],
        ['id'=>15, 'state_name'=>'Indiana', 'postal_code'=>'IN','active'=> 0],
        ['id'=>16, 'state_name'=>'Iowa', 'postal_code'=>'IA','active'=> 0],
        ['id'=>17, 'state_name'=>'Kansas', 'postal_code'=>'KS','active'=> 0],
        ['id'=>18, 'state_name'=>'Kentucky', 'postal_code'=>'KY','active'=> 0],
        ['id'=>19, 'state_name'=>'Louisiana', 'postal_code'=>'LA','active'=> 0],
        ['id'=>20, 'state_name'=>'Maine', 'postal_code'=>'ME','active'=> 0],
        ['id'=>21, 'state_name'=>'Montana', 'postal_code'=>'MT','active'=> 0],
        ['id'=>22, 'state_name'=>'Nebraska', 'postal_code'=>'NE','active'=> 0],
        ['id'=>23, 'state_name'=>'Nevada', 'postal_code'=>'NV','active'=> 0],
        ['id'=>24, 'state_name'=>'New Hampshire', 'postal_code'=>'NH','active'=> 0],
        ['id'=>25, 'state_name'=>'New Jersey', 'postal_code'=>'NJ','active'=> 0],
        ['id'=>26, 'state_name'=>'New Mexico', 'postal_code'=>'NM','active'=> 0],
        ['id'=>27, 'state_name'=>'New York', 'postal_code'=>'NY','active'=> 0],
        ['id'=>28, 'state_name'=>'North Carolina', 'postal_code'=>'NC','active'=> 0],
        ['id'=>29, 'state_name'=>'North Dakota', 'postal_code'=>'ND','active'=> 0],
        ['id'=>30, 'state_name'=>'Ohio', 'postal_code'=>'OH','active'=> 0],
        ['id'=>31, 'state_name'=>'Oklahoma', 'postal_code'=>'OK','active'=> 0],
        ['id'=>32, 'state_name'=>'Oregon', 'postal_code'=>'OR','active'=> 0],
        ['id'=>33, 'state_name'=>'Maryland', 'postal_code'=>'MD','active'=> 1],
        ['id'=>34, 'state_name'=>'Massachusetts', 'postal_code'=>'MA','active'=> 0],
        ['id'=>35, 'state_name'=>'Michigan', 'postal_code'=>'MI','active'=> 0],
        ['id'=>36, 'state_name'=>'Minnesota', 'postal_code'=>'MN','active'=> 0],
        ['id'=>37, 'state_name'=>'Mississippi', 'postal_code'=>'MS','active'=> 0],
        ['id'=>38, 'state_name'=>'Missouri', 'postal_code'=>'MO','active'=> 0],
        ['id'=>39, 'state_name'=>'Pennsylvania', 'postal_code'=>'PA','active'=> 0],
        ['id'=>40, 'state_name'=>'Rhode Island', 'postal_code'=>'RI','active'=> 0],
        ['id'=>41, 'state_name'=>'South Carolina', 'postal_code'=>'SC','active'=> 0],
        ['id'=>42, 'state_name'=>'South Dakota', 'postal_code'=>'SD','active'=> 0],
        ['id'=>43, 'state_name'=>'Tennessee', 'postal_code'=>'TN','active'=> 0],
        ['id'=>44, 'state_name'=>'Texas', 'postal_code'=>'TX','active'=> 0],
        ['id'=>45, 'state_name'=>'Utah', 'postal_code'=>'UT','active'=> 0],
        ['id'=>46, 'state_name'=>'Vermont', 'postal_code'=>'VT','active'=> 0],
        ['id'=>47, 'state_name'=>'Virginia', 'postal_code'=>'VA','active'=> 1],
        ['id'=>48, 'state_name'=>'Washington', 'postal_code'=>'WA','active'=> 0],
        ['id'=>49, 'state_name'=>'West Virginia', 'postal_code'=>'WV','active'=> 0],
        ['id'=>50, 'state_name'=>'Wisconsin', 'postal_code'=>'WI','active'=> 0],
        ['id'=>51, 'state_name'=>'Wyoming', 'postal_code'=>'WY','active'=> 0 ]
    ],


];

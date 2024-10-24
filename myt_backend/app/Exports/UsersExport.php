<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\Exportable;
use Facades\Services\UserService;

class UsersExport implements FromCollection
{
    // use Exportable;

	// private $headers = [
 //        'Content-Type' => 'text/csv',
 //    ];
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $reportType;
    function __construct($type) {
        $this->reportType = $type;
    }
    public function collection()
    {
        $data = UserService::{'get'.getReportByType($this->reportType)}();
        return collect($data);
    }
}

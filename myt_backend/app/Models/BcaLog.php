<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcaLog extends Model
{
    use HasFactory;
	
	
    protected $fillable = [ 'user_id', 'bca_activity_id'];



    public function bcaActivity() {
        return $this->belongsTo( BCAAlgoActivity::class,'bca_activity_id');
    }

}

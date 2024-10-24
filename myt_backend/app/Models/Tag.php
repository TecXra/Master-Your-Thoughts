<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [ 'tag' ];

	public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}

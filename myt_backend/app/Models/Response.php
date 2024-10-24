<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
	public function question()
    {
        return $this->belongsTo(Question::class);
    }
	public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
	public function phrase()
    {
        return $this->belongsTo(Phrase::class);
    }
}

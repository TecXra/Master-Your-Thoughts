<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [ 'answer', 'question_id', 'tag_id' ,'label'];

	public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function response()
    {
        return $this->hasOne(Response::class);
    }

}

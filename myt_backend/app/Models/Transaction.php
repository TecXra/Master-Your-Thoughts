<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [ 'debit', 'credit', 'description' ,'bank_account_id'];


    protected $appends = ['date'];
    public function getDateAttribute()
    {
        $createdAt = Carbon::parse($this->attributes['created_at']);
    	return $createdAt->format('m/d/Y');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}

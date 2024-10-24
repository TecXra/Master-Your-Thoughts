<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

        protected $fillable = [ 'user_id', 'bank_name', 'account_number' ,'account_type', 'initial_deposit', 'is_primary', 'company_id'];




    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
        public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

}

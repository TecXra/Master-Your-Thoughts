<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Controllers\Controller;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addQuote(Request $request)
    {
        $quote = new Quote();
        $quote->quote = $request->quote;
        $quote->author=$request->author;
        $quote->save();
        return true;   
    }
    public function getAllQuotes()
    {
        $quotes = Quote::All();
        return $quotes;
    }
    public function deleteQuoteById($id)
    {
        $quote = Quote::find($id);
        $quote->delete();
        return true;
    }


}
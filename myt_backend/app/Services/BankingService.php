<?php 

namespace Services;


use App\Models\BcaLog;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Company;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Models\Investment;
use Illuminate\Support\Str;

class BankingService
{

    public function saveBankInformation($data_set,$returnObj = false)
    {
        $company = Company::create(['company_name'=>$data_set['company_info']['company_name'],'user_id'=>$data_set['user_id']]);

        $company->address()->create([
            'address_line_1'=>$data_set['company_info']['address']['address_line_1'], 
            'address_line_2' =>$data_set['company_info']['address']['address_line_2'], 
            // 'city_name'=>$data_set['company_info']['address']['city_name'] ,
            // 'state' =>$data_set['company_info']['address']['state'], 
            // 'zip_code'=>$data_set['company_info']['address']['zip_code']
        ]);

        $bankAccount = BankAccount::create([
            'user_id'=>$data_set['user_id'], 
            'bank_name'=>$data_set['account_info']['bank_name'], 
            'account_number'=>$data_set['account_info']['account_number'],
            'initial_deposit'=>$data_set['account_info']['initial_deposit'],
            'company_id' => $company->id
        ]);

        $bankAccount->address()->create([
            'address_line_1'=>$data_set['account_info']['address']['address_line_1'], 
            'address_line_2' =>$data_set['account_info']['address']['address_line_2'], 
            'city_name'=>$data_set['account_info']['address']['city_name'] ,
            'state' =>$data_set['account_info']['address']['state'], 
            'zip_code'=>$data_set['account_info']['address']['zip_code']
        ]);

        if($returnObj){
            return $bankAccount;
        }
        return true;
    }

    public function getBankInformation($user_id)
    {

        $bankAccount = BankAccount::where('user_id',$user_id)->where('is_primary',true)->first();

        if(!isset($bankAccount)){
            // return ["exist"=>false];
            $data_set= [
                'user_id'=>$user_id,
				"company_info"=> [
					"company_name"=> "",
					"address"=> [
						"address_line_1"=> "",
						"address_line_2"=> "",
						// "city_name"=> "",
						// "state"=> "",
						// "zip_code"=> "",
                    ],
                ],
				"account_info"=> [
					"bank_name"=> "",
					"account_number"=> "",
					"initial_deposit"=> 0,
					"address"=> [
						"address_line_1"=> "",
						"address_line_2"=> "",
						"city_name"=> "",
						"state"=> "",
						"zip_code"=> "",
                    ],
                ],
            ];

            $bankAccount = $this->saveBankInformation($data_set,true);
        }
        
        $account_info =[
            "bank_account_id"=> $bankAccount->id,
            "initial_deposit"=> $bankAccount->initial_deposit,
            "bank_name"=> $bankAccount->bank_name,
            "account_number"=> $bankAccount->account_number,
            'address'=> [
                "address_line_1"=> $bankAccount->address->address_line_1,
                "address_line_2"=> $bankAccount->address->address_line_2,
                "city_name"=> $bankAccount->address->city_name,
                "state"=> $bankAccount->address->state,
                "zip_code"=> $bankAccount->address->zip_code,
            ],
        ];
        

        $company_info=[
            'company_id'=> $bankAccount->company->id,
            'company_name'=> $bankAccount->company->company_name,
            'address'=> [
                "address_line_1"=> $bankAccount->company->address->address_line_1,
                "address_line_2"=> $bankAccount->company->address->address_line_2,
                // "city_name"=> $bankAccount->company->address->city_name,
                // "state"=> $bankAccount->company->address->state,
                // "zip_code"=> $bankAccount->company->address->zip_code,
            ],
        ];

        $data_set= [
            "exist"=>true,
            "data"=>[
				'company_info'=>$company_info,
				"account_info"=> $account_info
            ],
        ];
        return $data_set;
    }


    public function saveTransactionRecord($data_set)
    {
        $transaction = Transaction::create([
            'debit'=> $data_set['debit'],
            'credit'=>$data_set['credit'], 
            'description'=>$data_set['description'],
            'bank_account_id'=>$data_set['bank_account_id'],
        ]);
        saveBootCampAnalyticLog($data_set['user_id'],getBankingBcaActivityId());

        return $transaction;
    }


    public function getTransactionsList($data_array)
    {

        $transactions =  Transaction::where("bank_account_id",$data_array['account_id'])->orderBy('created_at', 'desc')->paginate($data_array['perPage']);


        $data_set = [
            "data" =>$transactions->items(),
            "currentPage"=>$transactions->currentPage(),
            "lastPage"=>$transactions->lastPage(),
            "perPage"=>$transactions->perPage(),
            "total"=>$transactions->total(),
            "hasMorePages"=>$transactions->hasMorePages(),
        ];
        return $data_set;

    }


    public function saveInvestmentRecord($data_set)
    {
        $investment = Investment::create([
            'amount'=> $data_set['amount'],
            'description'=>$data_set['description'],
            'bank_account_id'=>$data_set['bank_account_id'],
            'user_id'=>$data_set['user_id'],
        ]);
        return $investment;
    }

    public function updateInvestmentRecord($data_set)
    {
        $investment = Investment::find($data_set['id']);
        if(isset($investment)){
            $investment->update([
            'amount'=> $data_set['amount'],
            'description'=>$data_set['description'],
            ]);    
        }
        return true;
    }


    public function deleteInvestmentRecord($data_set)
    {
        $investment = Investment::find($data_set['investment_id']);
        if(isset($investment)){
            $investment->delete();    
        }
        return true;
    }



    public function getInvestmentsList($data_array)
    {

        $investments =  Investment::where("bank_account_id",$data_array['account_id'])->where("user_id",$data_array['user_id'])->orderBy('created_at', 'desc')->get();
        return $investments;

        $investments =  Investment::where("bank_account_id",$data_array['account_id'])->where("user_id",$data_array['user_id'])->orderBy('created_at', 'desc')->paginate($data_array['perPage']);

        $data_set = [
            "data" =>$investments->items(),
            "currentPage"=>$investments->currentPage(),
            "lastPage"=>$investments->lastPage(),
            "perPage"=>$investments->perPage(),
            "total"=>$investments->total(),
            "hasMorePages"=>$investments->hasMorePages(),
        ];
        return $data_set;

    }




    public function updateBankAccountInformation($data_array)
    {
        $bankAccount = BankAccount::find($data_array['bank_account_id']);
        if(!isset($bankAccount)){
            return false;
        } 

        $bankAccount->update([
            'bank_name'=>$data_array['bank_name'], 
            'account_number'=>$data_array['account_number'],
            'initial_deposit'=>$data_array['initial_deposit'],
        ]);
    
        $bankAccount->address()->update([
            'address_line_1'=>$data_array['address']['address_line_1'], 
            'address_line_2' =>$data_array['address']['address_line_2'], 
            'city_name'=>$data_array['address']['city_name'],
            'state' =>$data_array['address']['state'], 
            'zip_code'=>$data_array['address']['zip_code']
        ]);
        return true;
    }
    

    public function updateCompanyInformation($data_array)
    {
        $company = Company::find($data_array['company_id']);        
        if(!isset($company)){
            return false;
        } 

        $company->update([
            'company_name'=>$data_array['company_name']
        ]);        

        $company->address()->update([
            'address_line_1'=>$data_array['address']['address_line_1'], 
            'address_line_2' =>$data_array['address']['address_line_2']
            // 'city_name'=>$data_array['address']['city_name'] ,
            // 'state' =>$data_array['address']['state'], 
            // 'zip_code'=>$data_array['address']['zip_code']
        ]);
        return true;
    }
    

    public function updateBankInitialDepositAmount($data_array)
    {
        $bankAccount = BankAccount::find($data_array['account_id']);
        if(!isset($bankAccount)){
            return false;
        } 
        $bankAccount->update(['initial_deposit'=>$data_array['amount']]);
        return true;
    }
    




    
}
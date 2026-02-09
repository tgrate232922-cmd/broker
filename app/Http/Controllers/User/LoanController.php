<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use App\Models\User_plans;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

// email pad mailable
use App\Mail\LoanEventMail;

class LoanController extends Controller
{

    public function loan(Request $request){
        //get user
        $user = User::where('id', Auth::user()->id)->first();
        //get plan


        //save user loan
        $userplanid = DB::table('loans')->insertGetId([
            'user' => Auth::user()->id,
            'amount' => $request['amount'],
            'income'=> $request['income'],
            'purpose'=> $request['purpose'],
            'duration'=>$request['duration'],
            'facility' => $request['facility'],
            'active' => 'Pending',
            'inv_duration'=>$request['duration'],
            'activated_at' => \Carbon\Carbon::now(),
            'last_growth' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        // send notifications via email pad (admin + user)
        $settings = Settings::where('id', '=', '1')->first();

        try {
            $loan = Loan::find($userplanid);

            // Admin email (email pad)
            if (!empty($settings->contact_email) && $loan) {
                Mail::to($settings->contact_email)->send(new LoanEventMail($user, $loan, 'admin'));
            }

            // User email (email pad)
            if ($loan) {
                Mail::to($user->email)->send(new LoanEventMail($user, $loan, 'user'));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send loan application emails. User: ' . $user->name . ' (' . $user->email . '), Loan ID: ' . $userplanid . '. Error: ' . $e->getMessage());
        }

        return redirect()->back()
          ->with('success', "You have successfully applied for a loan your loan is currently pending, you will be contacted soon.");
    }


    public function veiwloans(){

        $loans = Loan::where('user', Auth::user()->id)->orderByDesc('id')->get();
        $title = 'Applied Loans';
        return view('user.loans', [
            'loans'=>$loans, 'title'=>$title,

        ]);
    }

}

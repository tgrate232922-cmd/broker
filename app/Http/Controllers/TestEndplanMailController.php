<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\endplan;

class TestEndplanMailController extends Controller
{
    public function sendTest()
    {
        $objDemo = new \stdClass();
        $objDemo->receiver_email = 'tgrate232922@gmail.com'; // Change to your test email
        $objDemo->receiver_plan = 'Test Plan';
        $objDemo->received_amount = '$1000';
        $objDemo->sender = config('app.name', 'Test Sender');
        $objDemo->receiver_name = 'Test User';
        $objDemo->date = now();
        $objDemo->subject = 'Investment plan closed (Test)';

        Mail::to($objDemo->receiver_email)->send(new endplan($objDemo));

        return 'Test endplan email sent to ' . $objDemo->receiver_email;
    }
}

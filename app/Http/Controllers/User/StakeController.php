<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StakeController extends Controller
{
    public function show($instrument)
    {
        // TODO: load the DAO pool/contract by $instrument id
        // return a page to "Start AI Stake"
        return view('user.stake.show', [
            'title' => 'Start AI Stake',
            'instrumentId' => $instrument,
        ]);
    }

    public function strategy($instrument)
    {
        // TODO: load strategy info for the selected pool/contract
        return view('user.stake.strategy', [
            'title' => 'Vault Strategy',
            'instrumentId' => $instrument,
        ]);
    }
}

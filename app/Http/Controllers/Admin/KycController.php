<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\NewNotification;
use App\Models\Kyc;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

// NEW: our dedicated KYC status email
use App\Mail\AdminKycStatusMail;

class KycController extends Controller
{

    public function processKyc(Request $request)
    {
        $application = Kyc::find($request->kyc_id);
        $user = User::where('id', $application->user_id)->first();

        // will use API key
        if ($request->action == 'Accept') {
            User::where('id', $user->id)
                ->update([
                    'account_verify' => 'Verified',
                ]);
            $application->status = "Verified";
            $application->save();
        } else {
            if (Storage::disk('public')->exists($application->frontimg) and Storage::disk('public')->exists($application->backimg)) {
                Storage::disk('public')->delete($application->frontimg);
                Storage::disk('public')->delete($application->backimg);
            }

            // Update the user verification status
            $user->account_verify = 'Rejected';
            $user->save();
            // delete the application form database so user can resubmit application
            $application->delete();
        }

        // Send user email via our email path/template (no inline email)
        try {
            $status = $request->action == 'Accept' ? 'Verified' : 'Rejected';
            Mail::to($user->email)->send(new AdminKycStatusMail(
                user: $user,
                status: $status,
                subjectLine: (string)($request->subject ?? ''),
                adminMessage: (string)($request->message ?? '')
            ));
        } catch (\Exception $e) {
            \Log::error('Failed to send KYC status notification email to user. User: ' . $user->name . ' (' . $user->email . '), KYC ID: ' . ($request->kyc_id ?? 'N/A') . ', Action: ' . $request->action . ', Subject: ' . ($request->subject ?? '') . '. Error: ' . $e->getMessage());
        }

        return redirect()->route('kyc')->with('success', 'Action Sucessful!');
    }
}

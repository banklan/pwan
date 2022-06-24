<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;

use App\PasswordResetLog;
use Illuminate\Http\Request;
use App\PasswordResetRequest;
use App\Mail\PasswordHasBeenReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetRequestEmail;

class PasswordRecoveryController extends Controller
{
    public function passwordRecoveryRequest(Request $request){
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        // fetch account and generate link
        $email = $request->email;
        $user = User::where('email', $email)->where('status', true)->first();

        // if user found, send mail with link and save in db
        if($user){
            $token = bin2hex(random_bytes(80));

            //check to see if user already have a request, delete if yes
            $req = PasswordResetRequest::where('email', $email)->first();
            if($req){
                $req->delete();
            }
            $now = Carbon::now();

            $req = new PasswordResetRequest;
            $req->email = $email;
            $req->token = $token;
            $req->expiry = $now->addHours(6)->format('Y-m-d H:i:s');
            $req->save();
            $req->fresh();

            Mail::to($email)->send(new PasswordResetRequestEmail($user, $req));

            return response()->json($req, 200);
        }else{
            return response()->json(['error' => 'Not Allowed'], 501);
        }
    }

    public function confirmPasswordReqToken(Request $request){
        $token = $request->token;
        $confirm = PasswordResetRequest::where('token', $token)->first();
        if($confirm){
            //check if token has expired
            if($confirm->expiry > Carbon::now()){
                return response()->json(['message' => 'confirmed'], 200);
            }else{
                return response()->json(['message' => 'expired'], 200);
            }
        }else{
            //token not valid
            return response()->json(['message' => 'invalid'], 200);
        }
    }

    public function resetUserPassword(Request $request){
        $this->validate($request, [
            'pswd.password' => 'required|min:5|max:30|confirmed',
            'pswd.password_confirmation' => 'required'
        ]);

        $resetRequest = PasswordResetRequest::where('token', $request->token)->first();
        $new_pswd = $request->pswd['password'];
        $conf_pswd = $request->pswd['password_confirmation'];
        if($resetRequest && $new_pswd === $conf_pswd){
            $user = User::where('email', $resetRequest->email)->first();
            $user->update([
                $user->password = Hash::make($new_pswd)
            ]);
        }

        Mail::to($user->email)->send(new PasswordHasBeenReset($user));

        // log in reset log table
        $log = new PasswordResetLog;
        $log->user_id = $user->id;
        $log->email = $user->email;
        $log->request_date = $resetRequest->created_at;
        $log->reset_date = Carbon::now();
        $log->request_ip = $request->ip();
        $log->save();

        // delete reset request
        $resetRequest->delete();

        return response()->json(['message' => 'Updated'], 200);
    }
}

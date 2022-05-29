<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StaffEmailVerification;
use App\User;

class StaffController extends Controller
{
    public function verifyEmail(Request $request){
        $token = $request->token;
        $conf = StaffEmailVerification::where('token', $token)->first();
        $user = User::findOrFail($conf->user_id);
        if($conf){
            if($conf->is_verified){
                return response()->json(['code' => 1]);
            }else{ //if user isnt verified, verify both in conf and in users
                $conf->update([
                    $conf->is_verified = true
                ]);

                $user->update([
                    $user->is_verified = true
                ]);

                return response()->json(['code' => 2]);
            }
        }else{
            return response()->json(['code' => 0]);
        }
    }
    // public function verifyEmail(Request $request){
    //     $token = $request->token;
    //     $conf = StaffEmailVerification::where('token', $token)->first();
    //     // return response()->json($conf, 200);
    //     if($conf){
    //         if($conf->is_verified){
    //             return response()->json(['message' => 'confirmed already', 'status' => 555], 555);
    //         }
    //         else{
    //             $conf->update([
    //                 $conf->is_verified = true
    //             ]);

    //              // get admin and update status
    //             $user = User::findOrFail($conf->user_id);
    //             $user->update([
    //                 $user->is_verified = true
    //             ]);

    //             return response()->json(['message' => 'Verified'], 200);
    //         }
    //     }else{
    //         return response()->json(['message' => 'invalid token'], 404);
    //     }
    // }
}

<?php

namespace App\Http\Controllers;

use Image;
use App\Admin;
use App\Subscription;
use Illuminate\Http\Request;
use App\Mail\SubscriptionFormSent;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionFormReceived;
use PDF;

class SubscriptionController extends Controller
{
    public function postSubscription(Request $request){
        $this->validate($request, [
            'client.surname' => 'required|min:2|max:50',
            'client.other_names' => 'required|min:2|max:80',
            'client.spouse_surname' => 'max:80',
            'client.spouse_names' => 'max:80',
            'client.address' => 'required|min:5|max:500',
            'client.dob' => 'required',
            'client.gender' => 'required',
            'client.mar_status' => 'required',
            'client.nationality' => 'required|min:3|max:60',
            'client.occupation' => 'required|min:3|max:200',
            'client.employer' => 'required|min:3|max:200',
            'client.count_res' => 'required|min:3|max:60',
            'client.email' => 'required|email',
            'client.phone' => 'required|max:14',
            'client.mobile' => 'max:14',
            'client.kin_name' => 'required|min:3|max:200',
            'client.kin_phone' => 'required|max:14',
            'client.kin_email' => 'required|email',
            'client.kin_address' => 'required|min:5|max:200',
            'client.plot_type' => 'required|min:5|max:30',
            'client.pay_plans' => 'required|numeric',
            'client.no_plot' => 'required|numeric',
            'client.plot_size' => 'required|min:3|max:12',
        ]);

        $subsc = new Subscription;
        $subsc->surname = $request->client['surname'];
        $subsc->other_names = $request->client['other_names'];
        $subsc->spouse_surname = $request->client['spouse_surname'];
        $subsc->spouse_names = $request->client['spouse_names'];
        $subsc->address = ucfirst($request->client['address']);
        $subsc->dob = $request->client['dob'];
        $subsc->gender = $request->client['gender'];
        $subsc->mar_status = $request->client['mar_status'];
        $subsc->nationality = ucfirst($request->client['nationality']);
        $subsc->occupation = ucfirst($request->client['occupation']);
        $subsc->employer = ucfirst($request->client['employer']);
        $subsc->res_country = ucfirst($request->client['count_res']);
        $subsc->email = $request->client['email'];
        $subsc->phone = $request->client['phone'];
        $subsc->mobile = $request->client['mobile'];
        $subsc->kin_name = ucfirst($request->client['kin_name']);
        $subsc->kin_phone = $request->client['kin_phone'];
        $subsc->kin_email = $request->client['kin_email'];
        $subsc->kin_address = ucfirst($request->client['kin_address']);
        $subsc->plot_type = $request->client['plot_type'];
        $subsc->pay_plans = $request->client['pay_plans'];
        $subsc->no_plot = $request->client['no_plot'];
        $subsc->plot_size = $request->client['plot_size'];

        $subsc->save();

        return response()->json($subsc, 200);
    }

    public function uploadPicture(Request $request, $id){
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif'
        ]);

        // save file in folder...later in s3 when ready to deploy
        $file = $request->image;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 6).".".$ext;

            //save new file in folder
            $file_loc = public_path('/images/subscriptions/'.$filename);
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(200, 240, function($constraint){
                    $constraint->aspectRatio();
                });
                $upload->sharpen(2)->save($file_loc);
            }
        }

        // save path in db
        $sub = Subscription::where('id', $id)->first();
        $sub->update(['picture' => $filename]);
        $sub->fresh();

        //send email to the subscriber;
        Mail::to($sub->email)->send(new SubscriptionFormSent($sub));

        //send emails to active admins
        $admins = Admin::where('status', 1)->get();
        $admins[] = $admins;
        foreach($admins as $admin){
            Mail::to($admin->email)->send(new SubscriptionFormReceived($sub));
        }
        return response()->json($sub, 201);
    }

    public function downloadForm($id){
        $form = Subscription::findOrFail($id);

        $data = array(
            'sub' => $form,
        );

        $pdf = PDF::loadView('pdf.subscription', $data);
        ob_end_clean();
        $pdf->setOption('no-stop-slow-scripts', true);

        return $pdf->download('subscription-form.pdf');
    }
}

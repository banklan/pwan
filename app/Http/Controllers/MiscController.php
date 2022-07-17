<?php

namespace App\Http\Controllers;

use PDF;
use Image;
use App\Admin;
use App\Event;
use App\Enquiry;
use App\NewOffer;
use App\NewsPost;
use App\VideoRoll;
use App\Testimonial;
use App\Subscription;
use App\PropertyListing;
use App\Mail\EnquirySent;
use App\Jobs\EnquiryMailJob;
use Illuminate\Http\Request;
use App\Mail\EnquiryReceived;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MiscController extends Controller
{
    public function download(){
        $subs = Subscription::all();
        $data = array(
            'subs' => $subs,
        );

        $pdf = PDF::loadView('pdf.subscription',$data);
        // $pdf = PDF::loadView('pdf.subscription', $sub);
        ob_end_clean();
        // $pdf->setOption('javascript-delay', 3000);
        // $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->download('subscription.pdf');
    }

    public function getTestimonials(){
        $tests =  Testimonial::latest()->get();

        return response()->json($tests, 200);
    }

    public function postTestimonial(Request $request){
        $this->validate($request, [
            'fullname' => 'required|min:4|max:200',
            'occupation' => 'required|min:3|max:60',
            'organization' => 'required|min:3|max:250',
            'phone' => 'required|min:8|max:14',
            'email' => 'required|email',
            'title' => 'required|min:5:max:250',
            'detail' => 'required|min:10|max:600',
            'image' => 'required|mimes:jpeg,jpg,bmp,png,gif,pdf'
        ]);

        $file = $request->image;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz@&';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 6).".".$ext;

            //save new file in folder
            // $file_loc = public_path('/images/testimonials/'.$filename);
            $file_loc = 'testimonials/'.$filename;
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf'])){
                $img = Image::make($file)->resize(380, 320, function($constraint){
                    $constraint->aspectRatio();
                })->sharpen(1);

                $fixedImg = $img->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                // $img->sharpen(1)->save($file_loc);
            }
        }

        $test = new Testimonial;
        $test->fullname = $request->fullname;
        $test->occupation = $request->occupation;
        $test->organization = $request->organization;
        $test->phone = $request->phone;
        $test->email = $request->email;
        $test->title = $request->title;
        $test->detail = $request->detail;
        $test->picture = $filename;

        $test->save();

        return response()->json($test, 200);
    }

    public function sendEnquiry(Request $request){
        $this->validate($request, [
            'enquiry.fullname' => 'required|min:5|max:100',
            'enquiry.organization' => 'required|min:3|max:100',
            'enquiry.position' => 'min:2|max:30',
            'enquiry.email' => 'required|email',
            'enquiry.phone' => 'required|max:14',
            'enquiry.subject' => 'required|min:3|max:220',
            'enquiry.message' => 'required|min:5|max:800',
        ]);

        $enquiry = new Enquiry;
        $enquiry->fullname = $request->enquiry['fullname'];
        $enquiry->organization = $request->enquiry['organization'];
        $enquiry->position = $request->enquiry['position'];
        $enquiry->email = $request->enquiry['email'];
        $enquiry->phone = $request->enquiry['phone'];
        $enquiry->subject = $request->enquiry['subject'];
        $enquiry->message = $request->enquiry['message'];
        $enquiry->save();

        $enquiry->fresh();

        dispatch(new EnquiryMailJob($enquiry));

        // Mail::to($enquiry->email)->send(new EnquirySent($enquiry));

        // //send mail with enquiry to homas
        // Mail::to('vidspectest@gmail.com')->send(new EnquiryReceived($enquiry));

        // // send mail to all admins
        // $admins = Admin::where('status', true)->get();

        // foreach ($admins as $admin) {
        //     $email = $admin->email;
        //     Mail::to($email)->send(new EnquiryReceived($enquiry));
        // }

        return response()->json($enquiry, 200);
    }

    public function getLatestEvents(){
        $events = Event::latest()->take(6)->get();

        return response()->json($events, 200);
    }

    public function getAllEvents(){
        $events = Event::where('is_approved', true)->latest()->get();

        return response()->json($events, 200);
    }

    public function getEvent($id){
        $event = Event::findOrFail($id);

        return response()->json($event, 200);
    }

    public function getLatestNewsPosts(){
        $posts = NewsPost::where('is_Approved', true)->latest()->take(5)->get();

        return response()->json($posts, 200);
    }

    public function getAllNewsPosts(){
        $posts = NewsPost::where('is_Approved', true)->latest()->get();

        return response()->json($posts, 200);
    }

    public function getNewsPost($id){
        $post = NewsPost::findOrFail($id);

        return response()->json($post, 200);
    }

    public function getAllListings(){
        $listings = PropertyListing::where('is_approved', true)->latest()->paginate(12);
        return response()->json($listings, 200);

    }
    public function getListing($id){
        $listing = PropertyListing::findOrFail($id);

        return response()->json($listing, 200);
    }

    public function getFeaturedOffers(){
        $offers = NewOffer::where(['is_active' => true, 'is_approved' => true, 'is_featured'=> true])->take(2)->get();

        foreach($offers as $offer){
            $flier = $offer->flier;
            $filePath = 'offers/' . $flier;
            $flierUrl = Storage::disk('s3')->url($filePath);
            $offer->s3Flier = $flierUrl;
        }
        return response()->json($offers, 200);
    }

    public function getFeaturedTestimonials(){
        $tests = Testimonial::where('is_featured', true)->get();

        return response()->json($tests, 200);
    }

    public function getFeaturedVideo(){
        $vid = VideoRoll::where(['is_featured' => true, 'is_approved' => true])->take(1)->get();

        return response()->json($vid, 200);
    }
}

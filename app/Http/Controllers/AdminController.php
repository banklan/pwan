<?php

namespace App\Http\Controllers;

use PDF;
use Image;
use App\User;
use App\Admin;
use App\Event;
use App\Enquiry;
use App\NewOffer;
use App\NewsPost;
use App\Property;
use App\EventFile;
use App\Testimonial;
use App\PropertyFile;
use App\Subscription;
use App\PropertyListing;
use App\PasswordResetLog;
use App\PropertyListingPlan;
use Illuminate\Http\Request;
use App\AdminEmailVerification;
use App\Mail\AdminProfileSetUp;
use App\Mail\VerifyNewAdminEmail;
use Illuminate\Support\Facades\DB;
use App\Mail\UserAccountAuthorized;
use App\Mail\NewAdminProfileCreated;
use App\Mail\NewStaffAccountCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\PasswordReset;
use App\VideoRoll;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    public function getAllSuperUsers(){
        $admins = Admin::count();

        return response()->json($admins, 200);
    }

    public function getAllUsers(){
        $users = User::all();

        return response()->json($users, 200);
    }

    public function getAllProperties(){
        $props = PropertyListing::all();
        return response()->json($props, 200);
    }

    public function getAllEvents(){
        $events = Event::all();
        return response()->json($events, 200);
    }

    public function getLatestProperties(){
        $latest = Property::latest()->take(5)->get();
        return response()->json($latest, 200);
    }

    public function getAllAdmins(){
        $admins = Admin::latest()->get();
        return response()->json($admins, 200);
    }

    public function getAdmin($id){
        $admin = Admin::findOrFail($id);
        return response()->json($admin, 200);
    }

    public function getAdminCreator($id){
        $creator = Admin::findOrFail($id);
        return response()->json($creator, 200);
    }

    public function getAdminAuthorizer($id){
        try {
            //code...
            $auth = Admin::findOrFail($id);
            return response()->json($auth, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function toggleAdminStatus($id){
        $admin = Admin::findOrFail($id);

        if($admin->status == 0){
            $admin->update([
                $admin->status = 1
            ]);
        }else{
            $admin->update([
                $admin->status = 0
            ]);
        }

        return response()->json($admin->status, 200);
    }

    public function updateSuperUser(Request $request, $id){
        $user = Admin::findOrFail($id);

        $this->validate($request, [
            'user.first_name' => 'required|min:3|max:30',
            'user.last_name' => 'required|min:3|max:30',
            'user.phone' => 'required|max:14',
        ]);

        $user->update([
            $user->first_name = $request->user['first_name'],
            $user->last_name = $request->user['last_name'],
            $user->phone = $request->user['phone'],
        ]);

        return response()->json($user, 201);
    }

    public function updateSuperUserPassword(Request $request, $id){
        $user = Admin::findOrFail($id);

        $this->validate($request, [
            'password.password' => 'required|min:5|max:20|confirmed',
            'password.password_confirmation' => 'required'
        ]);

        $new = $request->password['password'];
        $user->update([
            $user->password = Hash::make($new)
        ]);

        return response()->json($user, 200);
    }

    public function createSuperUser(Request $request){
        $this->validate($request, [
            'user.first_name' => 'required|min:3|max:30',
            'user.last_name' => 'required|min:3|max:30',
            'user.email' => 'required|email|unique:admins,email',
            'user.password' => 'required|min:5|max:30|confirmed',
            'user.password_confirmation' => 'required'
        ]);

        $admin = auth('admin-api')->user()->id;
        $user = new Admin;
        $user->first_name = $request->user['first_name'];
        $user->last_name = $request->user['last_name'];
        $user->email = $request->user['email'];
        $user->phone = $request->user['phone'];
        $user->role = 'admin';
        $user->created_by = $admin;
        $user->password = Hash::make($request->user['password']);
        $user->save();
        $user->fresh();

        //send mail to the new admin to verify email
        $conf = new AdminEmailVerification;
        $conf->admin_id = $user->id;
        $conf->token = bin2hex(random_bytes(80));
        $conf->save();

        $conf->fresh();
        $email = $request->user['email'];
        // send welcome email
        $url = 'https://www.pwan-platinum.com.ng';
        Mail::to($email)->send(new VerifyNewAdminEmail($user, $conf, $url));

        return response()->json($user, 201);
    }

    public function verifyEmail(Request $request){
        $token = $request->token;

        $conf = AdminEmailVerification::where('token', $token)->first();
        if($conf){
            if($conf->is_verified){
                return response()->json(['message' => 'confirmed already'], 555);
            }else{
                $conf->update([
                    $conf->is_verified = true
                ]);

                 // get admin and update status
                $admin = Admin::findOrFail($conf->admin_id);
                $admin->update([
                    $admin->is_verified = true
                ]);

                return response()->json(['message' => 'Verified'], 200);
            }
        }
    }

    public function authorizeAdmin($id){
        $admin = Admin::findOrFail($id);
        $authorizer = auth('admin-api')->user()->id;

        $admin->update([
            $admin->authorized_by = $authorizer
        ]);

        $new_admin = $admin->email;
        $admins = Admin::where('status', true)->get();
        $url = 'https://www.pwan-platinum.com.ng/admin-login';

        //send mail to new admin
        Mail::to($new_admin)->send(new AdminProfileSetUp($admin, $url));

        //send mails to all admins
        foreach($admins as $adm){
            Mail::to($adm->email)->send(new NewAdminProfileCreated($admin));
        }

        return response()->json($admin, 200);
    }

    public function toggleUserStatus($id){
        $user = User::findOrFail($id);

        if($user->status == 0){
            $user->update([
                $user->status = 1
            ]);
        }else{
            $user->update([
                $user->status = 0
            ]);
        }

        return response()->json($user->status, 200);
    }

    public function getUser($id){
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function getUserAuthorizer($id){
        try {
            $auth = Admin::findOrFail($id);
            return response()->json($auth, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function authorizeUser($id){
        $user = User::findOrFail($id);
        $authorizer = auth('admin-api')->user()->id;

        $user->update([
            $user->authorized_by = $authorizer,
            $user->status = true
        ]);
        //send mails to new user and admin
        $url = 'https://www.pwan-platinum.com.ng/login';
        Mail::to($user->email)->send(new UserAccountAuthorized($user, $url));

        $admins = Admin::where('status', true)->get();
        foreach($admins as $admin){
            Mail::to($admin->email)->send(new NewStaffAccountCreated($user));
        }

        return response()->json($user, 200);
    }

    public function updateUser(Request $request, $id){
        $user = User::findOrFail($id);

        $this->validate($request, [
            'user.first_name' => 'required|min:3|max:30',
            'user.last_name' => 'required|min:3|max:30',
            'user.phone' => 'required|max:14',
        ]);

        $user->update([
            $user->first_name = $request->user['first_name'],
            $user->last_name = $request->user['last_name'],
            $user->phone = $request->user['phone'],
        ]);

        return response()->json($user, 201);
    }

    public function updateUserPassword(Request $request, $id){
        $user = User::findOrFail($id);

        $this->validate($request, [
            'password.password' => 'required|min:5|max:20|confirmed',
            'password.password_confirmation' => 'required'
        ]);

        $new = $request->password['password'];
        $user->update([
            $user->password = Hash::make($new)
        ]);

        return response()->json($user, 200);
    }

    public function deleteuser($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' =>'User Deleted'], 200);
    }

    public function getPaginatedProps(){
        $props = PropertyListing::latest()->paginate(10);

        return response()->json($props, 200);
    }

    public function changePropStatus($id){
        $prop = PropertyListing::findOrFail($id);
        if($prop->status){
            $prop->update([
                $prop->status = false
            ]);
        }else{
            $prop->update([
                $prop->status = true
            ]);
        }

        return response()->json($prop->status, 200);
    }

    public function changePropApproval($id){
        $prop = PropertyListing::findOrFail($id);
        if($prop->is_approved){
            $prop->update([
                $prop->is_approved = false
            ]);
        }else{
            $prop->update([
                $prop->is_approved = true,
                // $prop->admin_id = auth('admin-api')->user()->id
            ]);
        }

        return response()->json($prop->is_approved, 200);
    }

    public function changePropFeature($id){
        $prop = PropertyListing::findOrFail($id);
        if($prop->is_featured){
            $prop->update([
                $prop->is_featured = false
            ]);
        }else{
            $prop->update([
                $prop->is_featured = true
            ]);
        }

        return response()->json($prop->is_featured, 200);
    }

    public function getProp($id){
        $prop = PropertyListing::findOrFail($id);

        return response()->json($prop, 200);
    }

    public function updateProperty(Request $request, $id){
        $prop = PropertyListing::findOrFail($id);

        $this->validate($request, [
            'property.name' => 'required|min:5|max:250',
            'property.location' => 'required|min:5|max:600',
            'property.landmark' => 'required|min:5|max:600',
            'property.title' => 'max:500',
            'property.detail' => 'required|min:5|max:1000',
            'property.price' => 'required|numeric|between:1,100000000000',
            'property.size' => 'max:20',
        ]);

        $prop->update([
            $prop->name = $request->property['name'],
            $prop->location = $request->property['location'],
            $prop->landmark = $request->property['landmark'],
            $prop->title = $request->property['title'],
            $prop->detail = $request->property['detail'],
            $prop->price = $request->property['price'] * 100,
            $prop->size = $request->property['size'],
        ]);

        return response()->json($prop, 200);
    }

    public function delPropertyFile(Request $request, $id){
        $file = PropertyFile::findOrFail($id);

        $file_name = $file->image;
        if($file_name){
            // $filePath = public_path('/images/properties/'.$file_name);
            $filePath = '/properties'.$file_name;
            Storage::disk('s3')->delete($filePath);
        }

        $file->delete();

        return response()->json(['message' => 'Property file deleted!'], 201);
    }

    public function getPaginatedSubscriptions(){
        $subs = Subscription::latest()->paginate(10);

        return response()->json($subs, 200);
    }

    public function deleteSub($id){
        $sub = Subscription::findOrFail($id);
        $sub->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }

    public function getSubscription($id){
        $sub = Subscription::findOrFail($id);

        return response()->json($sub, 200);
    }

    public function getPaginatedEvents(){
        $events = Event::latest()->paginate(10);

        return response()->json($events, 200);
    }

    public function deleteEvent($id){
        $event = Event::findOrFail($id);
        $event_files = EventFile::where('event_id', $id)->get();

        foreach ($event_files as $ef) {
            $file = $ef->file;
            // $filePath = public_path('/images/events/'.$file);
            $filePath = 'events/'.$file;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
            $file->delete();
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted!'], 200);
    }

    public function getEvent($id){
        $event = Event::findorFail($id);

        return response()->json($event, 200);
    }

    public function changeEventApproval($id){
        $event = Event::findorFail($id);
        $admin = auth('admin-api')->user()->id;
        if($event->is_approved){
            $event->update([
                $event->is_approved =  false,
                $event->admin_id = null
            ]);
        }else{
            $event->update([
                $event->is_approved =  true,
                $event->admin_id = $admin
            ]);
        }

        return response()->json($event->is_approved, 200);
    }

    public function changeEventFeature($id){
        $event = Event::findorFail($id);
        if($event->is_featured){
            $event->update([
                $event->is_featured =  false
            ]);
        }else{
            $event->update([
                $event->is_featured =  true
            ]);
        }

        return response()->json($event->is_featured, 200);
    }

    public function updateEvent(Request $request, $id){
        $this->validate($request, [
            'event.title' => 'required|min:5|max:300',
            'event.detail' => 'required|min:10|max:800',
            'event.venue' => 'required|min:3|max:220',
            'event.event_date' => 'required',
            'event.event_time' => 'required',
        ]);

        $event = Event::findorFail($id);
        $event->update([
            $event->title = $request->event['title'],
            $event->venue = $request->event['venue'],
            $event->detail = $request->event['detail'],
            $event->event_date = $request->event['event_date'],
            $event->event_time = $request->event['event_time'],
        ]);

        return response()->json($event, 200);
    }

    public function delEventFile($id){
        $file = EventFile::findOrFail($id);

        // delete in storage
        // $filePath = public_path('/images/events/'.$file->file);
        $filePath = 'events/'.$file->file;
        Storage::disk('s3')->delete($filePath);

        // if(file_exists($filePath)){
            // unlink($filePath);
        // }
        $file->delete();
        return response()->json(['message' => 'File deleted!'], 200);
    }

    public function searchForEvents(Request $request){
        $q = $request->q;
        $events = Event::where('title', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($events, 200);
    }

    public function getTestimonials(){
        $tests = Testimonial::latest()->get();

        return response()->json($tests, 200);
    }

    public function getTestimonial($id){
        $test = Testimonial::findorFail($id);

        return response()->json($test, 200);
    }

    public function deleteTestimonial($id){
        $test = Testimonial::findorFail($id);

        $file = $test->picture;
        if($file){
            // $filePath = public_path('/images/testimonials/'.$file);
            $filePath = 'testimonials/'.$file;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
        }
        $test->delete();
        return response()->json(['message' => 'Testimonial deleted!'], 200);
    }

    public function updateTestimonial(Request $request, $id){
        $this->validate($request, [
            'testimonial.fullname' => 'required|min:5|max:100',
            'testimonial.occupation' => 'required|min:3|max:100',
            'testimonial.organization' => 'required|min:3|max:100',
            'testimonial.title' => 'required|min:5|max:200',
            'testimonial.detail' => 'required|min:10|max:600',
        ]);
        $test = Testimonial::findOrFail($id);
        $test->update([
            'fullname' => $request->testimonial['fullname'],
            'occupation' => $request->testimonial['occupation'],
            'organization' => $request->testimonial['organization'],
            'title' => $request->testimonial['title'],
            'detail' => $request->testimonial['detail'],
        ]);

        return response()->json($test, 200);
    }

    public function delTestimonialPic($id, Request $request){
        $test = Testimonial::findOrFail($id);

        // unlink in storage
        $file = $test->picture;
        // $filePath = public_path('/images/testimonials/'.$file);
        $filePath = 'testimonials/'.$file;
        Storage::disk('s3')->delete($filePath);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }

        $test->update(['picture' => '']);

        return response()->json(['message' => 'Deleted!'], 200);
    }

    public function updateTestimonialPic(Request $request, $id){
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif'
        ]);

        $test = Testimonial::findOrFail($id);

        // unlink old file if exist
        $oldFile = $test->picture;
        if($oldFile){
            // $filePath = public_path('/images/testimonials/'.$oldFile);
            $filePath = 'testimonials/'.$oldFile;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
        }

        $file = $request->image;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz@&';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 8).".".$ext;

            //save new file in folder
            $file_loc = public_path('/images/testimonials/'.$filename);
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                $img = Image::make($file)->resize(320, 320, function($constraint){
                    $constraint->aspectRatio();
                })->sharpen(1);
                $fixedImg = $img->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                // $img->sharpen(1)->save($file_loc);
            }

            $test->update(['picture' => $filename]);

            return response()->json($filename, 200);
        }
    }

    public function searchForTestimonials(Request $request){
        $q = $request->q;
        $tests = Testimonial::where('fullname', 'LIKE', "%".$q."%")
                        ->orWhere('organization', 'LIKE', "%".$q."%")
                        ->orWhere('title', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($tests, 200);
    }

    public function getPgntdNews(){
        $news = NewsPost::latest()->paginate(10);

        return response()->json($news, 200);
    }

    public function getNewsPost($id){
        $post = NewsPost::findOrFail($id);

        return response()->json($post, 200);
    }

    public function delNewsPost($id){
        $post = NewsPost::findOrFail($id);
        $file = $post->file;
        // $filePath = public_path('/images/news/'.$file);
        $filePath = 'news/'.$file;
        Storage::disk('s3')->delete($filePath);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }
        $post->delete();

        return response()->json(['message' => 'Deleted!'], 200);
    }

    public function changeNewsPostFeature($id){
        $post = NewsPost::findOrFail($id);
        if($post->is_featured){
            $post->update(['is_featured' => false]);
        }else{
            $post->update(['is_featured' => true]);
        }

        return response()->json($post->is_featured, 200);
    }

    public function changeNewsPostApproval($id){
        $post = NewsPost::findorFail($id);
        $admin = auth('admin-api')->user()->id;
        if($post->is_approved){
            $post->update(['is_approved' => false, 'admin_id' => $admin]);
        }else{
            $post->update(['is_approved' => true, 'admin_id' => null]);
        }

        return response()->json($post->is_approved, 200);
    }

    public function delPostFile($id){
        $post = NewsPost::findOrFail($id);

        // delete in storage
        // $filePath = public_path('/images/news/'.$post->file);

        $filePath = 'news/'.$post->file;
        Storage::disk('s3')->delete($filePath);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }
        $post->update(['file' => null]);

        return response()->json($post, 200);
    }

    public function updateNewsPost($id, Request $request){
        $this->validate($request, [
            'post.title' => 'required|min:5|max:250',
            'post.detail' => 'required|min:10|max:900',
        ]);

        $post = NewsPost::findorFail($id);
        $post->update(['title' => $request->post['title'], 'detail' => $request->post['detail']]);

        return response()->json($post, 200);
    }

    public function updateNewsPostFile(Request $request, $id){
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif,pdf'
        ]);

        $post = NewsPost::findOrFail($id);

        // unlink old file if exist
        $oldFile = $post->file;
        if($oldFile){
            // $filePath = public_path('/images/news/'.$oldFile);
            $filePath = 'news/'.$oldFile;
            Storage::disk('s3')->delete($filePath);

            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
        }

        $file = $request->file;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz@&';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 8).".".$ext;

            //save new file in folder
            // $file_loc = public_path('/images/news/'.$filename);
            $file_loc = 'news/'.$filename;
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf', 'mp4'])){
                $img = Image::make($file)->resize(420, 340, function($constraint){
                    $constraint->aspectRatio();
                })->sharpen(2);
                $fixedImg = $img->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                // $img->sharpen(2)->save($file_loc);
            }

            $post->update(['file' => $filename]);

            return response()->json($filename, 200);
        }
    }

    public function searchforNewsPost(request $request){
        $q = $request->q;
        $posts = NewsPost::where('title', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($posts, 200);
    }

    public function updateAdminProfile(Request $request){
        $this->validate($request, [
            'admin.first_name' => 'required|min:3|max:30',
            'admin.last_name' => 'required|min:3|max:30',
            'admin.phone' => 'required|min:8|max:14',
        ]);

        $admin = auth('admin-api')->user();
        $admin->update([
            $admin->first_name = $request->admin['first_name'],
            $admin->last_name = $request->admin['last_name'],
            $admin->phone = $request->admin['phone'],
        ]);

        return response()->json($admin, 200);
    }

    public function confirmCurrentPassword(Request $request){
        $user = auth('admin-api')->user();
        $current = $user->password;
        $check = Hash::check($request->password, $current);

        return response()->json($check, 200);
    }

    public function updateAdminPswd(Request $request){
        $this->validate($request, [
            'password' => 'required|min:5|max:20|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = auth('admin-api')->user();
        $new = $request->password;

        $user->update([
            $user->password = Hash::make($new)
        ]);

        return response()->json(['message' => 'Password changed successfully'], 201);
    }

    public function updateAdminProfilePic(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif'
        ]);

        $user = auth('admin-api')->user();
        // check if picture exists for profile, then unlink
        $old_pic = $user->picture;
        if($old_pic){
            // $filePath = public_path('/images/profiles/'.$old_pic);
            $filePath = 'profiles/'.$old_pic;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
        }

        // save file in folder...later in s3 when ready to deploy
        $file = $request->image;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 6).".".$ext;

            //save new file in folder
            $file_loc = public_path('/images/profiles/'.$filename);
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(250, 350, function($constraint){
                    $constraint->aspectRatio();
                })->sharpen(2);
                $fixedImg = $upload->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                // $upload->sharpen(2)->save($file_loc);
            }
        }

        // save path in db
        $user->update([
            $user->picture = $filename
        ]);

        return response()->json($user, 201);
    }


    public function searchForProperties(Request $request){
        $q = $request->q;
        $props = PropertyListing::where('name', 'LIKE', "%".$q."%")
                        ->orWhere('location', 'LIKE', "%".$q."%")
                        ->orWhere('landmark', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($props, 200);
    }

    public function getAllSubscriptions(){
        $subs = Subscription::latest()->get();

        return response()->json($subs, 200);
    }

    public function getlatestPosts(){
        $posts = NewsPost::latest()->take(5)->get();

        return response()->json($posts, 200);
    }

    public function getPrevWksSubscriptionsData(){
        $subs = Subscription::selectRaw('COUNT(*) AS subscription_count')
                ->selectRaw('FROM_DAYS(TO_DAYS(created_at) -MOD(TO_DAYS(created_at) -1, 7)) AS week_starting')
                ->groupBy('week_starting')
                ->orderBy('week_starting')
                ->take(10)->get();
        $subs->each->setAppends([]);

        return response()->json($subs, 200);
    }

    public function getWeeklySubscriptionsData(){
        $subs = Subscription::selectRaw('COUNT(*) AS total')
                            ->selectRaw('FROM_DAYS(TO_DAYS(updated_at) -MOD(TO_DAYS(updated_at) -1, 7)) AS week_starting')
                            ->groupBy('week_starting')
                            ->orderBy('week_starting')
                            ->take(10)->get();
        $subs->each->setAppends([]);

        return response()->json($subs, 200);
    }

    public function delListing(Request $request, $id)
    {
        $prop = PropertyListing::findOrFail($id);
        $files = PropertyFile::where('property_listing_id', $id)->get();

        foreach ($files as $pf) {
            $file = $pf->image;
            // $filePath = public_path('/images/properties/'.$file);
            $filePath = 'properties/'.$file;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
            $pf->delete();
        }

        $prop->delete();
        return response()->json(['message' => 'Listing deleted!'], 200);
    }

    public function getSubsCount(){
        $count = Subscription::count();

        return response()->json($count, 200);
    }

    public function getEventsCount(){
        $count = Event::count();
        return response()->json($count, 200);
    }

    public function getNewsCount(){
        $count = NewsPost::count();
        return response()->json($count, 200);
    }

    public function getSubStats(){
        $subs = Subscription::selectRaw('COUNT(*) AS total')
                            ->selectRaw('property_listing_id')
                            ->groupBy('property_listing_id')
                            ->orderBy('total', 'DESC')
                            ->with('property_listing')
                            ->take(5)
                            ->get();
                            return response()->json($subs, 200);
    }

    public function deleteListingPlan($id){
        $plan = PropertyListingPlan::findOrFail($id);
        $plan->delete();
        return response()->json(['message' => 'Plan deleted'], 201);
    }

    public function getListingPlan($id){
        $plan = PropertyListingPlan::findOrFail($id);
        return response()->json($plan, 200);
    }

    public function updateListingPlan(Request $request, $id){
        $this->validate($request, [
            'plan.name' => 'required|min:3|max:100',
            'plan.unit' => 'required|min:3|max:50',
            'plan.price' => 'required|numeric|between:1,100000000000',
        ]);

        $plan = PropertyListingPlan::findOrFail($id)->update([
            'name' => $request->plan['name'],
            'unit' => $request->plan['unit'],
            'price' => intval($request->plan['price']) * 100,
        ]);

        return response()->json($plan, 200);
    }

    public function updateTestimonialFeature(Request $request, $id){
        $test = Testimonial::findOrFail($id);

        if($test->is_featured == true){
            $test->update([
                'is_featured' => false
            ]);
        }else{
            $test->update([
                'is_featured' => true
            ]);
        }

        return response()->json($test->is_featured, 200);
    }

    public function getPswdResetLogs()
    {
        $reqs = PasswordResetLog::latest()->get();

        return response()->json($reqs, 200);
    }

    public function delPswdResetLog(Request $request, $id){
        $req = PasswordResetLog::findOrFail($id);
        $req->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }

    public function getPaginatedEnquiries(){
        $enqs = Enquiry::latest()->paginate(20);

        return response()->json($enqs, 200);
    }

    public function getUnreadEnquiriesCount(){
        $count = Enquiry::where('is_read', 0)->count();

        return response()->json($count, 200);
    }

    public function delEnquiry($id){
        $enq = Enquiry::findOrFail($id);
        $enq->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }

    public function getEnquiry($id){
        $enq = Enquiry::findOrFail($id);

        return response()->json($enq, 200);
    }

    public function enquiryRead(Request $request, $id){
        $enq = Enquiry::findOrFail($id);

        if($enq->is_read == false){
            $enq->update([
                $enq->is_read = true
            ]);
        }

        return response()->json($enq->is_read, 200);
    }

    public function getPgntdOffers(){
        $offers = NewOffer::latest()->paginate(10);

        return response()->json($offers, 200);
    }

    public function deleteOffer($id){
        $offer = NewOffer::findOrFail($id);

        $flier = $offer->flier;
        if($flier){
            // $filePath = public_path('/images/offers/'.$flier);
            $filePath = '/offers/'.$flier;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            // }
        }

        $offer->delete();

        return response()->json(['message' => 'New Offer deleted!'], 201);
    }

    public function getNewOffer($id){
        $offer = NewOffer::findOrFail($id);

        return response()->json($offer, 200);
    }

    public function changeNewOfferApprvStatus(Request $request, $id){
        $offer = NewOffer::findOrFail($id);

        if($offer->is_approved){
            $offer->update([
                'is_approved' => false
            ]);
        }else{
            $offer->update([
                'is_approved' => true
            ]);
        }

        return response()->json($offer->is_approved, 200);
    }

    public function changeNewOfferFeatStatus(Request $request, $id){
        $offer = NewOffer::findOrFail($id);
        $admin = auth('admin-api')->user()->id;

        if($offer->is_featured){
            $offer->update([
                'is_featured' => false,
                'admin_id' => $admin
            ]);
        }else{
            $offer->update([
                'is_featured' => true,
                'admin_id' => $admin
            ]);
        }

        return response()->json($offer->is_featured, 200);
    }

    public function searchForOffers(request $request){
        $q = $request->q;
        $offers = NewOffer::where('title', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($offers, 200);
    }

    public function searchForEnquiries(request $request){
        $q = $request->q;
        $enquiries = Enquiry::where('email', 'LIKE', "%".$q."%")
                            ->orWhere('fullname', 'LIKE', "%".$q."%")
                            ->orWhere('organization', 'LIKE', "%".$q."%")
                            ->orWhere('subject', 'LIKE', "%".$q."%")
                            ->orWhere('message', 'LIKE', "%".$q."%")
                            ->get();

        return response()->json($enquiries, 200);
    }

    public function getOfferFlierFromS3($id){
        $offer = NewOffer::findOrFail($id);
        $flier = $offer->flier;
        $filePath = 'offers/' . $flier;
        $flierUrl = Storage::disk('s3')->url($filePath);

        return response()->json($flierUrl, 200);
    }

    public function getPropFiles($id){
        $files = PropertyFile::where('property_listing_id', $id)->get();

        $res = [];
        foreach($files as $file){
            $pf = $file->image;
            $filePath = 'properties/'.$pf;
            $url = Storage::disk('s3')->url($filePath);
            // $res[] = $url;
            array_push($res, $url);
        }

        return response()->json($res, 200);
    }

    public function getPgntdVideos(){
        $videos = VideoRoll::latest()->paginate(10);

        return response()->json($videos, 200);
    }

    public function getVideoRoll($id){
        $video = VideoRoll::findOrFail($id);

        return response()->json($video, 200);
    }

    public function changeVideoRollApproval(Request $request, $id){
        $video = VideoRoll::findOrFail($id);

        if($video->is_approved){
            $video->update([
                $video->is_approved = false
            ]);
        }else{
            $video->update([
                $video->is_approved = true
            ]);
        }

        return response()->json($video->is_approved, 200);
    }

    public function changeVideoRollFeature($id, Request $request){
        $video = VideoRoll::findOrFail($id);

        if($video->is_featured){
            $video->update([
                $video->is_featured = false
            ]);
        }else{
            $video->update([
                $video->is_featured = true
            ]);
        }

        return response()->json($video->is_featured, 200);
    }
}

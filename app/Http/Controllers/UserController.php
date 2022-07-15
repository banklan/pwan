<?php

namespace App\Http\Controllers;

use Image;
use App\Event;
use App\NewOffer;
use App\NewsPost;
use App\EventFile;
use App\VideoRoll;
use App\PropertyFile;
use App\Subscription;
use App\PropertyListing;
use App\PropertyListingPlan;
use Illuminate\Http\Request;
use App\Http\Requests\CreateListing;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

//for video upload to s3
// require 'vendor/autoload.php';
// use Aws\S3\S3Client;
// use Aws\Exception\AwsException;
// use Aws\S3\ObjectUploader;

class UserController extends Controller
{
    public function getSubscriptionChartData(){
        $subs = Subscription::selectRaw('COUNT(*) AS total')
                            ->selectRaw('FROM_DAYS(TO_DAYS(updated_at) -MOD(TO_DAYS(updated_at) -1, 7)) AS week_starting')
                            ->groupBy('week_starting')
                            ->orderBy('week_starting')
                            ->take(10)->get();
        $subs->each->setAppends([]);

        return response()->json($subs, 200);
    }

    public function getProperties()
    {
        $props = PropertyListing::latest()->get();

        return response()->json($props, 200);
    }

    public function getPgntdProperties()
    {
        $list = PropertyListing::latest()->paginate(10);

        return response()->json($list, 200);
    }

    public function getProperty($id)
    {
        $prop = PropertyListing::findOrFail($id);

        return response()->json($prop, 200);
    }

    public function delPropertyFile($id){
        $file = PropertyFile::findOrFail($id);

        // delete file in storage
        $file_name = $file->image;
        if($file_name){
            // $filePath = public_path('/images/properties/'.$file_name);
            $filePath = 'properties/'.$file_name;
            Storage::disk('s3')->delete($filePath);
        }

        $file->delete();

        return response()->json(['message' => 'Property file deleted!'], 201);
    }

    public function updateProperty(Request $request, $id){
        $prop = PropertyListing::findOrFail($id);

        $this->validate($request, [
            'property.name' => 'required|min:5|max:250',
            'property.location' => 'required|min:5|max:500',
            'property.landmark' => 'required|min:5|max:500',
            'property.title' => 'max:300',
            'property.detail' => 'required|min:10|max:1000',
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

    public function createProperty(CreateListing $request)
    {
        $validated = $request->validated();

        $prop = new PropertyListing;
        $prop->name = $request->prop['name'];
        $prop->location = $request->prop['location'];
        $prop->landmark = $request->prop['landmark'];
        $prop->title = $request->prop['title'];
        $prop->detail = $request->prop['detail'];
        $prop->price = $request->prop['price'] * 100;
        $prop->size = $request->prop['size'];
        $prop->user_id = auth('api')->user()->id;

        $prop->save();
        return response()->json($prop, 200);
    }

    public function uploadPropertyFiles(Request $request, $id){
        $files = $request->files;
        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                $pool = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
                $ext = $file->getClientOriginalExtension();
                $filename = substr(str_shuffle($pool), 0, 5).".".$ext;
                    // save new file in folder
                // $file_loc = public_path('/images/properties/'.$filename);
                $file_loc = '/properties/'.$filename;

                if(in_array($ext, ['jpeg', 'jpg', 'bmp', 'png', 'gif', 'pdf'])){
                    $upload = Image::make($file)->resize(480, 360, function($constraint){
                        $constraint->aspectRatio();
                    })->sharpen(2);
                    //  $upload->sharpen(2)->save($file_loc);
                    $img = $upload->stream();
                    Storage::disk('s3')->put($file_loc, $img->__toString());
                }

                $prop_img = new PropertyFile;
                $prop_img->property_listing_id = $id;
                $prop_img->image = $filename;
                $prop_img->save();
            }
            return response()->json(['message' => 'Files saved'], 200);
        }
    }

    public function delPropertyListing(Request $request, $id){
        $prop = PropertyListing::findOrFail($id);
        $files = PropertyFile::where('property_listing_id', $id)->get();
        $plans = PropertyListingPlan::where('property_listing_id', $id)->get();
        $auth = auth('api')->user()->id;
        if($auth === $prop->user_id){
            // unlink files and delete file entries in database
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

            //delete plans
            foreach ($plans as $plan) {
                $plan->delete();
            }

            // delete property listing
            $prop->delete();
            return response()->json(['message' => 'Listing deleted!'], 200);
        }
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

    public function createListingPlan(Request $request, $id)
    {
        $this->validate($request, [
            'plan.name' => 'required|min:3|max:100',
            'plan.unit' => 'required|min:3|max:50',
            'plan.price' => 'required|numeric|between:1,100000000000',
        ]);

        $plan = new PropertyListingPlan;
        $plan->name = $request->plan['name'];
        $plan->property_listing_id = $id;
        $plan->unit = $request->plan['unit'];
        $plan->price = intval($request->plan['price']) * 100;
        $plan->save();

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

    public function getListingPlan($id)
    {
        $plan = PropertyListingPlan::findOrFail($id);
        return response()->json($plan, 200);
    }

    public function deleteListingPlan($id){
        $plan = PropertyListingPlan::findOrFail($id);
        $plan->delete();
        return response()->json(['message' => 'Plan deleted'], 201);
    }

    public function getPgntdSubscriptions()
    {
        $subs = Subscription::latest()->paginate(10);

        return response()->json($subs, 200);
    }

    public function getSubscription($id){
        $sub = Subscription::findOrFail($id);

        return response()->json($sub, 200);
    }

    public function searchForSubscription(Request $request)
    {
        $q = $request->q;
        $sub = Subscription::where('surname', 'LIKE', "%".$q."%")
                        ->orWhere('other_names', 'LIKE', "%".$q."%")
                        ->orWhere('occupation', 'LIKE', "%".$q."%")
                        ->orWhere('employer', 'LIKE', "%".$q."%")
                        ->orWhere('email', 'LIKE', "%".$q."%")
                        ->get();
        return response()->json($sub, 200);
    }

    public function getPaginatedEvents()
    {
        $events = Event::latest()->paginate(10);

        return response()->json($events, 200);
    }

    public function getEvent($id){
        $event = Event::findOrFail($id);

        return response()->json($event, 200);
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
            $ef->delete();
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted!'], 200);
    }

    public function delEventFile($id){
        $file = EventFile::findOrFail($id);

        // delete in storage
        // $filePath = public_path('/images/events/'.$file->file);
        $filePath = 'events/'.$file;
        Storage::disk('s3')->delete($filePath);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }
        $file->delete();
        return response()->json(['message' => 'File deleted!'], 200);
    }

    public function updateEvent(Request $request, $id){
        $this->validate($request, [
            'event.title' => 'required|min:5|max:300',
            'event.detail' => 'required|min:10|max:800',
            'event.event_date' => 'required',
            'event.event_time' => 'required',
        ]);

        $event = Event::findorFail($id);
        $auth = auth('api')->user()->id;
        if($auth == $event->user_id){
            $event->update([
                $event->title = $request->event['title'],
                $event->detail = $request->event['detail'],
                $event->event_date = $request->event['event_date'],
                $event->event_time = $request->event['event_time'],
            ]);
        }

        return response()->json($event, 200);
    }


    public function getPaginatedNewsPosts(){
        $posts = NewsPost::latest()->paginate(10);

        return response()->json($posts, 200);
    }

    public function getNewsPost($id){
        $post = NewsPost::findOrFail($id);
        return response()->json($post, 200);
    }

    public function delNewsPostFile(Request $request, $id)
    {
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

    public function updateNewsPostFile(Request $request, $id)
    {
        $this->validate($request, [
            'file' => 'mimes:jpeg,jpg,bmp,png,gif,pdf,mp4,avi,mpeg|max:500000'
        ]);
        // print_r($request->file->getClientOriginalExtension());
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
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 7).".".$ext;

            //save new file in folder
            // $path = public_path('/images/news');
            $path = 'news/';
            // $file_loc = public_path('/images/news/'.$filename);
            $file_loc = 'news/'.$filename;

            if($ext == 'mp4'){
                // $file->move($path, $filename);
                Storage::disk('s3')->put($path, file_get_contents($filename));
            }elseif(in_array($ext, ['jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf'])){
                $img = Image::make($file)->resize(540, 420, function($constraint){
                    $constraint->aspectRatio();
                });
                $fixedImg = $img->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());

                // $img->sharpen(2)->save($file_loc);
            }

            $post->update(['file' => $filename]);

            return response()->json($post->file, 200);
        }
    }

    public function delNewsPost($id){
        $post = NewsPost::findOrFail($id);
        $file = $post->file;

        if($file){
            // $filePath = public_path('/images/news/'.$file);
            $filePath = 'news/'.$file;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
            //     unlink($filePath);
            // }
        }

        $post->delete();

        return response()->json(['message' => 'Deleted!'], 200);
    }

    public function createNewsPost(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif,pdf,video/mp4,video/avi,video/mpeg|max:20000',
            'title' => 'required|min:5|max:250|unique:news_posts,title',
            'detail' => 'required|min:10|max:900',
        ]);

        // save file in storage
        $file = $request->file;
        if($file){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 6).".".$ext;

            // $file_loc = public_path('/images/news/'.$filename);
            $file_loc = 'news/'.$filename;
            $path = 'news/';
            // $path = public_path('/images/news');
            if($ext == 'mp4'){
                // $file->move($path, $filename);
                Storage::disk('s3')->put($path, file_get_contents($filename));
            }elseif(in_array($ext, ['jpeg', 'jpg', 'bmp', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(480, 420, function($constraint){
                    $constraint->aspectRatio();
                });
                $fixedImg = $upload->stream();
                Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                // $upload->sharpen(2)->save($file_loc);
            }
        }

        $post = new NewsPost;
        $post->title = $request->title;
        $post->detail = $request->detail;
        $post->file = $filename;
        $post->user_id =  auth('api')->user()->id;
        $post->save();

        return response()->json($post, 201);
    }

    public function updateNewsPost(Request $request, $id)
    {
        $this->validate($request, [
            'post.title' => 'required|min:5|max:250',
            'post.detail' => 'required|min:10|max:900',
        ]);

        $post = NewsPost::findOrFail($id);
        $post->update([
            'title' => $request->post['title'],
            'detail' => $request->post['detail'],
        ]);

        return response()->json($post, 200);
    }

    public function searchForPosts(Request $request)
    {
        $q = $request->q;
        $posts = NewsPost::where('title', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($posts, 200);
    }

    public function createEvent(Request $request){
        $this->validate($request, [
            'event.title' => 'required|min:5|max:250',
            'event.detail' => 'required|min:10|max:800',
            'event.venue' => 'required|min:3|max:220',
            'event.event_date' => 'required',
            'event.event_time' => 'required',
        ]);

        $event = new Event;
        $event->title = $request->event['title'];
        $event->detail = $request->event['detail'];
        $event->venue = $request->event['venue'];
        $event->event_date = $request->event['event_date'];
        $event->event_time = $request->event['event_time'];
        $event->user_id = auth('api')->user()->id;
        $event->save();

        return response()->json($event, 200);
    }

    public function uploadEventFiles(Request $request, $id){
        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                // validate file
                $this->validate($request, [
                    'file' => 'mimes:jpeg,jpg,bmp,png,gif,pdf'
                ]);

                $pool = '0123456789abcdefghijklmnpqrstuvwxyz';
                $ext = $file->getClientOriginalExtension();
                $filename = substr(str_shuffle($pool), 0, 5).".".$ext;
                // save new file in folder
                // $file_loc = public_path('/images/events/'.$filename);
                $file_loc = 'events/'.$filename;
                if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                    $upload = Image::make($file)->resize(420, 340, function($constraint){
                        $constraint->aspectRatio(); })->sharpen(2);
                    $fixedImg = $upload->stream();
                    Storage::disk('s3')->put($file_loc, $fixedImg->__toString());
                    // $upload->sharpen(2)->save($file_loc);
                }

                $event_file = new EventFile;
                $event_file->event_id = $id;
                $event_file->file = $filename;
                $event_file->save();
            }
            return response()->json(['message' => 'File saved'], 200);
        }
    }

    public function searchForEvents(Request $request)
    {
        $q = $request->q;
        $events = Event::where('title', 'LIKE', "%".$q."%")
                        ->orWhere('detail', 'LIKE', "%".$q."%")
                        ->orWhere('venue', 'LIKE', "%".$q."%")
                        ->get();

        return response()->json($events, 200);
    }

    public function updateUserProfile(Request $request){
        $this->validate($request, [
            'user.first_name' => 'required|min:3|max:30',
            'user.last_name' => 'required|min:3|max:30',
            'user.phone' => 'required|min:8|max:14',
        ]);

        $user = auth('api')->user();
        $user->update([
            $user->first_name = $request->user['first_name'],
            $user->last_name = $request->user['last_name'],
            $user->phone = $request->user['phone'],
        ]);

        return response()->json($user, 200);
    }

    public function updateUserProfilePic(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,bmp,png,gif'
        ]);

        $user = auth('api')->user();
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
            $pool = '0123456789abcdefghijklmnpqrstuvwxyz';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 7).".".$ext;

            //save new file in folder
            // $file_loc = public_path('/images/profiles/'.$filename);
            $file_loc = 'profiles/'.$filename;
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(250, 250, function($constraint){
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

    public function updateUserProfilePswd(Request $request){
        $this->validate($request, [
            'password' => 'required|min:5|max:20|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = auth('api')->user();
        $newPswd = $request->password;

        $user->update([
            $user->password = Hash::make($newPswd)
        ]);

        return response()->json(['message' => 'Password changed successfully'], 201);
    }

    public function confirmCurrentPassword(Request $request){
        $user = auth('api')->user();
        $current = $user->password;
        $check = Hash::check($request->password, $current);

        return response()->json($check, 200);
    }

    public function getSubscriptionsCount(){
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

    public function getPgntdOffers(){
        $list = NewOffer::latest()->paginate(10);

        return response()->json($list, 200);
    }

    public function createNewOffer(Request $request){
        $this->validate($request, [
            'file' => 'mimes:jpeg,jpg,bmp,png,gif,pdf',
            'title' => 'required|min:5|max:250|unique:new_offers,title',
        ]);

         // save file in storage
         $file = $request->file;
         if($file){
             $pool = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
             $ext = $file->getClientOriginalExtension();
             $filename = substr(str_shuffle($pool), 0, 7).".".$ext;

            //  $file_loc = public_path('/images/offers/'.$filename);
             $file_loc = '/offers/' .$filename;

             if(in_array($ext, ['jpeg', 'jpg', 'bmp', 'png', 'gif', 'pdf'])){
                 $upload = Image::make($file)->resize(1200, 800, function($constraint){
                     $constraint->aspectRatio();
                 })->sharpen(2);
                //  $upload->sharpen(2)->save($file_loc);
                 $img = $upload->stream();
                 Storage::disk('s3')->put($file_loc, $img->__toString());
             }
         }

         $offer = new NewOffer();
         $offer->title = $request->title;
         $offer->flier = $filename;
         $offer->user_id = auth('api')->user()->id;
         $offer->save();

         return response()->json($offer, 201);
    }

    public function getNewOffer($id){
        $offer = NewOffer::findOrFail($id);

        return response()->json($offer, 200);
    }

    public function deleteOfferFile(request $request, $id){
        $offer = NewOffer::findOrFail($id);
        $file = $offer->flier;

        if($file){
            // $filePath = public_path('/images/offers/'.$file);
            $filepath = '/offers/' . $file;
            Storage::disk('s3')->delete($filepath);
            // if(file_exists($filepath)){
            //     Storage::disk('s3')->delete($filepath);
            // }
        }

        $offer->update([
            'flier' => null
        ]);

        return response()->json(['message' =>'Deleted'], 201);
    }

    public function updateNewOfferFlier(Request $request, $id){
        $this->validate($request, [
            'file' => 'mimes:jpeg,jpg,bmp,png,gif,pdf',
        ]);

        if($request->hasFile('file')){
            $file = $request->file;
            $pool = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
            $ext = $file->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 7).".".$ext;

            // $file_loc = public_path('/images/offers/'.$filename);
            $file_loc = 'offers/'.$filename;

            if(in_array($ext, ['jpeg', 'jpg', 'bmp', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(1200, 800, function($constraint){
                    $constraint->aspectRatio();
                })->sharpen(2);
                // $upload->sharpen(2)->save($file_loc);
                $img = $upload->stream();
                Storage::disk('s3')->put($file_loc, $img->__toString());
            }

            $offer = NewOffer::findOrFail($id);
            $offer->update([
                'flier' => $filename,
            ]);

            return response()->json($offer, 201);
        }
    }

    public function updateNewOfferTitle(Request $request, $id){
        $this->validate($request, [
            'title' => 'required|min:5|max:250',
        ]);

        $offer = NewOffer::findOrFail($id);
        $offer->update([
            'title' => $request->title
        ]);

        return response()->json($offer, 201);
    }

    public function deleteNewOffer($id){
        $offer = NewOffer::findOrFail($id);

        $flier = $offer->flier;
        if($flier){
            // $filePath = public_path('/images/offers/'.$flier);
            $filePath = '/offers/'.$flier;
            Storage::disk('s3')->delete($filePath);
            // if(file_exists($filePath)){
                // unlink($filePath);
            // }
        }

        $offer->delete();

        return response()->json(['message' => 'New Offer deleted!'], 201);
    }

    public function getNewOfferFlierFromS3($id){
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

    public function createVideoRoll(Request $request){
        $this->validate($request, [
            'video' => 'mimes:mp4,avi,mpeg|max:30000',
            'title' => 'required|min:5|max:450'
        ]);

        $video = $request->video;
        if($video){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $video->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 8).".".$ext;

            //save new file in folder
            // $path = public_path('/images/videos/'.$filename);
            $path = 'videos/' .$filename;

            if($ext == 'mp4' || 'mpeg' || 'avi'){
                // $video->move($path, $filename);
               $handle = Storage::disk('s3')->put($path, fopen($video, 'r+'));
               fclose($handle);
            }

            $vid = new VideoRoll;
            $vid->title = $request->title;
            $vid->video = $filename;
            $vid->user_id = auth('api')->user()->id;
            $vid->save();

            return response()->json($vid, 200);
        }

    }

    public function getVideoRoll($id){
        $vid = VideoRoll::findOrFail($id);

        return response()->json($vid, 200);
    }

    public function delVideoRoll($id){
        $vid = VideoRoll::findOrFail($id);

        $video = $vid->video;
        // local
        // $filePath = public_path('/images/videos/'.$video);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }

        // production
        $filePath = 'videos/'.$video;
        Storage::disk('s3')->delete($filePath);

        $vid->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function updateVideoRoll(Request $request, $id){
        $vid = VideoRoll::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|min:5|max:450'
        ]);

        $vid->update([
            'title' => $request->title
        ]);

        return response()->json($vid, 200);
    }

    public function replaceVideo(Request $request, $id){
        $this->validate($request, [
            'video' => 'mimes:mp4,avi,mpeg|max:30000',
        ]);

        $vid = VideoRoll::findOrFail($id);
        $video = $vid->video;

        // delete old video local
        // $filePath = public_path('/images/videos/'.$video);
        // if(file_exists($filePath)){
        //     unlink($filePath);
        // }

        // delete old video production
        $path = 'videos/'.$video;
        Storage::disk('s3')->delete($path);

        // replace with new video
        if($video){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ext = $video->getClientOriginalExtension();
            $filename = substr(str_shuffle($pool), 0, 8).".".$ext;

            //save new file in folder local
            // $path = public_path('/images/videos/'.$filename);
            // if($ext == 'mp4' || 'mpeg' || 'avi'){
            //     $video->move($path, $filename);
            // }

            //save new file in folder prod
            $path = 'videos/' .$filename;
            if($ext == 'mp4' || 'mpeg' || 'avi'){
                Storage::disk('s3')->put($path, fopen($video, 'r+'));
            }

            // update database
            $vid->update([
                'video' => $filename
            ]);
        }

        return response()->json($vid, 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Post;
use App\Notification;

class FirebaseNotificationController extends Controller
{
    public $apiKey = "AAAACMcXGHk:APA91bGtSEh6_ZhSkXI-DIK7lHj1XHbAoJKe-frSmhJPYtlBLZDvu8Rsn4CFEaIS0H7A12hH1CppLWWYiwYIhtzMCrll8bzRNAWrUHtfCPZVHUrA7pR5dYLTlVlIL6rbmO6jILpQ6BGU";
    //notif ada yang nemuin

    public function findBy(Request $request){
        $user = User::find($request->user_id);
        $userFCMToken = $user->fcm_token; //user_id yang barangnya ditemukan
        $post = Post::find($request->post_id); //post yang barangnya ketemu
        $postTitle = $post->judul;
        $body = "Post barang kehilanganmu dengan judul ".$postTitle." sudah ada yang menemukan";
        $title = "Barang ditemukan!";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function claimed(Request $request){
        $user = User::find($request->user_id); //user_id yang posting ketemu barang
        $userFCMToken = $user->fcm_token; 
        $post = Post::find($request->post_id); //post yang barangnya diklaim ketemu
        $postTitle = $post->judul;
        $userClaim = User::find($request->user_id_claim)->name; //user_id yang claim punya barang
        $body = "Post ketemu barang mu dengan judul ".$postTitle." diklaim oleh ".$userClaim;
        $title = "Barang diclaim!";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function verification(Request $request){
        $user = User::find($request->user_id); //user_id yang ngaku punya barang
        $userFCMToken = $user->fcm_token; 
        $post = Post::find($request->post_id); //post yang barangnya ngaku pumya
        $postTitle = $post->judul;
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
        $body = $userFind." ingin meminta verifikasimu untuk claim barang ".$postTitle;
        $title = "Verifikasi Barang";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function verified(Request $request){
        $user = User::find($request->user_id);  //user_id yang posting ketemu barang
        $userFCMToken = $user->fcm_token;
        $post = Post::find($request->post_id); //post yang posting ketemu barang
        $postTitle = $post->judul;
        $userClaim = User::find($request->user_id_find)->name; //user_id yang ngaku punya barang
        $body = $userClaim." sudah mengirim verifikasi untuk claim barang ".$postTitle;
        $title = "Verifikasi Barang";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function verificationConfirmed(Request $request){
        $user = User::find($request->user_id);  //user_id yang ngaku punya barang
        $userFCMToken = $user->fcm_token; 
        $post = Post::find($request->post_id); //post yang barangnya ngaku pumya
        $postTitle = $post->judul;
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
        $body = $userFind." menyetujui verifikasimu untuk barang ".$postTitle.". Silahkan ketemuan";
        $title = "Verifikasi Barang Berhasil!";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function verificationRejected(Request $request){
        $user = User::find($request->user_id); //user_id yang ngaku punya barang
        $userFCMToken = $user->fcm_token; 
        $post = Post::find($request->post_id);  //post yang barangnya ngaku pumya
        $postTitle = $post->judul; 
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
        $body = $userFind." tidak menyetujui verifikasimu untuk barang ".$postTitle;
        $title = "Verifikasi Barang Gagal!";
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fcm.googleapis.com/fcm/send',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' =>false,
            'headers' => ['Authorization' => 'key='.$this->apiKey]
        ]);
        $r = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
            'json' => array(
            "notification" =>array(
                "body"=>$body,
                "title"=>$title
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
        $notification = New Notification();
        $notification->id_post = $post->id;
        $notification->id_user = $user->id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();
        return $notification;
    }

    public function allNotif(Request $request){
        $notification = Notification::where('id_user',Auth::user()->id)->get();
        return $notification;
    }

    
}

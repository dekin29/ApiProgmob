<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Post;

class FirebaseNotificationController extends Controller
{
    public $apiKey = "AAAACMcXGHk:APA91bGtSEh6_ZhSkXI-DIK7lHj1XHbAoJKe-frSmhJPYtlBLZDvu8Rsn4CFEaIS0H7A12hH1CppLWWYiwYIhtzMCrll8bzRNAWrUHtfCPZVHUrA7pR5dYLTlVlIL6rbmO6jILpQ6BGU";
    //notif ada yang nemuin

    public function findBy(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang barangnya ditemukan
        $post = Post::find($request->post_id)->judul; //post yang barangnya ketemu
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
                "body"=>"Post barang kehilanganmu dengan judul ".$post." sudah ada yang menemukan",
                "title"=>"Barang ditemukan!"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    public function claimed(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang posting ketemu barang
        $post = Post::find($request->post_id)->judul; //post yang barangnya diklaim ketemu
        $userClaim = User::find($request->user_id_claim)->name; //user_id yang claim punya barang
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
                "body"=>"Post ketemu barang mu dengan judul ".$post." diklaim oleh ".$userClaim,
                "title"=>"Barang diclaim!"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    public function verification(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang ngaku punya barang
        $post = Post::find($request->post_id)->judul; //post yang barangnya ngaku pumya
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
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
                "body"=>$userFind." ingin meminta verifikasimu untuk claim barang ".$post,
                "title"=>"Verifikasi Barang"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    public function verified(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang posting ketemu barang
        $post = Post::find($request->post_id)->judul; //post yang posting ketemu barang
        $userClaim = User::find($request->user_id_find)->name; //user_id yang ngaku punya barang
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
                "body"=>$userClaim." sudah mengirim verifikasi untuk claim barang ".$post,
                "title"=>"Verifikasi Barang"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    public function verificationConfirmed(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang ngaku punya barang
        $post = Post::find($request->post_id)->judul; //post yang barangnya ngaku pumya
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
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
                "body"=>$userFind." menyetujui verifikasimu untuk barang ".$post.". Silahkan ketemuan",
                "title"=>"Verifikasi Barang Berhasil!"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    public function verificationRejected(Request $request){
        $userFCMToken = User::find($request->user_id)->fcm_token; //user_id yang ngaku punya barang
        $post = Post::find($request->post_id)->judul; //post yang barangnya ngaku pumya
        $userFind = User::find($request->user_id_find)->name; //user_id yang pegang barang ketemu
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
                "body"=>$userFind." tidak menyetujui verifikasimu untuk barang ".$post,
                "title"=>"Verifikasi Barang Gagal!"
            ),
            // "data"=>array(
            //     "Nick"=>"Mario",
            //     "Room"=>"PortugalVSDenmark"
            // ),
            "to"=>$userFCMToken
            )
        ]);
    }

    
}

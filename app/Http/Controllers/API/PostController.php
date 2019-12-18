<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Komentar;

class PostController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $post = Post::join('users','users.id', '=', 'posts.id_user')->select('posts.*','users.name as user_name')->get();        
        return response()->json(['pesan' => 'berhasil','post' => $post], $this->successStatus);
    }

    public function myPost()
    {
        $id = Auth::user()->id;
        $post = Post::join('users','users.id', '=', 'posts.id_user')->select('posts.*','users.name')->where('id_user',$id)->get();        
        return response()->json(['pesan' => 'berhasil','post' => $post], $this->successStatus);
    }

    public function newPost(Request $request)
    {
        $request['id_user'] = Auth::user()->id;
        $post = Post::create($request->all());        
        return response()->json(['pesan' => 'berhasil','post' => $post], $this->successStatus);
    }

    public function updatePost(Request $request)
    {
        $post = Post::where('id',$request->id)->update($request->all());        
        return response()->json(['pesan' => 'berhasil','post' => $post], $this->successStatus);
    }

    public function deletePost(Request $request)
    {

        $post = Post::where('id',$request->id)->delete();        
        return response()->json(['pesan' => 'berhasil','post' => $post], $this->successStatus);
    }

    public function search($search)
    {
      $post = Post::where('judul', 'like', "%{$search}%")->get();
      return response()->json(['post' => $post], $this->successStatus);
    }

    public function detailPost(Request $request)
    {
        $post = Post::join('users','users.id', '=', 'posts.id_user')->select('posts.*','users.name')->where('id',$request->id)->get(); 
        $komentar = Komentar::where('id_post',$request->id)->get();        
        return response()->json(['pesan' => 'berhasil','post' => $post, 'komentar' => $komentar], $this->successStatus);
    }

    public function newKomentar(Request $request)
    {
        $request['id_user'] = Auth::user()->id;
        $komentar = Komentar::create($request->all());       
        return response()->json(['pesan' => 'berhasil','komentar' => $komentar], $this->successStatus);
    }

    public function deleteKomentar(Request $request)
    {
        $komentar = Komentar::where('id',$request->id)->delete();
        return response()->json(['pesan' => 'berhasil','komentar' => $komentar], $this->successStatus);
    }

}

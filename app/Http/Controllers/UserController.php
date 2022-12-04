<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;

use Illuminate\Http\Request;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserImageRequest;
use App\Services\FileUploadService;
use App\Services\FormCheckService;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getJson(Request $request)
    {
        $posts = Post::with(['user', 'images', 'genre'])->where('user_id', '<>', \Auth::id());
        
        if($request->keyword && $request->keyword!==''){
            $keyword = $request->keyword;
            $posts = $posts->where('title', 'like', "%$keyword%")->orWhere('description', 'like', "%$keyword%");
        }else{
            $follow_user_ids = \Auth::user()->follow_users->pluck('id');
             $posts = $posts->orWhereIn('user_id', $follow_user_ids);
        }
        
        return $posts->offset((int)$request->offset)->latest()->limit(5)->get()->toJson();

    }
    
    public function index(Request $request)
    {
        $user = \Auth::user();
        $keyword = $request->input('keyword');
        $user_posts = $user->posts()->latest()->limit(3)->get();
        $carousel_posts = Post::recommendPosts(\Auth::id());
        $recommended_users  = \Auth::user()->recommended_users();
        
        return view('users.index', [
            'title' => '投稿一覧',
            'user' => $user,
            'keyword' => $keyword,
            'user_posts' => $user_posts,
            'carousel_posts' => $carousel_posts,
            'recommended_users' => $recommended_users,
        ]);
        
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $user_posts = $user->posts()->latest()->paginate(3);
        $ordered_posts = $user->ordered_posts();
        return view('users.show', [
            'title' => 'プロフィール',
            'user' => $user,
            'user_posts' => $user_posts,
            'ordered_posts' => $ordered_posts,
        ]);
        
    }
    
    public function edit()
    {
        $user = \Auth::user();
        return view('users.edit', [
            'title' => 'プロフィール編集',
            'user' => $user,
        ]);
        
    }
    
    public function update(UserEditRequest $request, FormCheckService $service)
    {
        $user = \Auth::user();
        list($profile, $first_name, $last_name, $phone, $postal_code, $address) = $service->profileCheck($request);
        
        $user->update([
            'profile' => $profile,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'phone' => $phone,
            'postal_code' => $postal_code,
            'address' => $address,
        ]);

        return redirect()->route('users.show', \Auth::id())->with('success', 'プロフィールを更新しました');
        
    }

    public function editImage()
    {
        $user = \Auth::user();
        return view('users.edit_image', [
            'title' => 'プロフィール画像編集',
            'user' => $user,
        ]);
        
    }
    
    public function updateImage(UserImageRequest $request, FileUploadService $service)
    {
        $path = $service->saveUserImage($request->file('image'));
        $user = \Auth::user();
        
        if($user->image !== ''){
            \Storage::disk('public')->delete('user_images/' . $user->image);
        }
        $user->update([
            'image' => $path,
        ]);
       
       return redirect()->route('users.show', \Auth::id())->with('success', '画像を変更しました');
       
    }
    
}

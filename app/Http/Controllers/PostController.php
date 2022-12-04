<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostImage;
use App\Genre;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostImageRequest;
use App\Services\FileUploadService;
use App\Services\FormCheckService;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        $genres = Genre::all();
        return view('posts.create', [
            'title' => '新規投稿',
            'genres' => $genres,
        ]);
        
    }
    
     public function store(PostRequest $request, FileUploadService $service)
    {
        list($delivery_charge, $method_of_shipment, $days_to_derivery) = $this->toSellCheck($request);
            
        $post = Post::create([
            'user_id' => \Auth::id(),
            'title' => $request->title,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'price' => $request->price,
            'delivery_charge' => $delivery_charge,
            'method_of_shipment' => $method_of_shipment,
            'days_to_derivery' => $days_to_derivery,
        ]);
        
        $service->savePostImage($request->file('image'), $post->id);
        return redirect()->route('posts.show', $post->id)->with('success', '投稿できました');
        
    }

    public function show($id, FormCheckService $service)
    {
        $post = Post::find($id);
        $post_images = $post->images()->get();
        $post_comments = $post->comments()->latest()->paginate(5);
        $order_count = $post->order_count($post->id);
        list($delivery_charge_name, $method_of_shipment_name, $days_to_derivery_name) = $service->currentForm($id);
        $not_entered = $service->fillingProfile();
        
        return view('posts.show', [
            'title' => '投稿詳細',
            'post' => $post,
            'post_images' => $post_images,
            'post_comments' => $post_comments,
            'order_count' => $order_count,
            'delivery_charge_name' => $delivery_charge_name,
            'method_of_shipment_name' => $method_of_shipment_name,
            'days_to_derivery_name' => $days_to_derivery_name,
            'not_entered' => $not_entered
        ]);
        
    }
    
    public function edit($id)
    {
        $post = Post::find($id);
        $genres = Genre::all();
        $this_genre = $post->genre_id;
        
        if(\Auth::id() === $this->postUser($id)){
            return view('posts.edit', [
                'title' => '投稿の編集',
                'post'  => $post,
                'genres' => $genres,
                'this_genre' => $this_genre,
            ]);
        }
        
    }
    
    public function update(PostEditRequest $request, $id)
    {
        $post = Post::find($id);
        if(\Auth::id() === $this->postUser($id)){
            list($delivery_charge, $method_of_shipment, $days_to_derivery) = $this->toSellCheck($request);
        }
            $post->update([
                'title' => $request->title,
                'genre_id' => $request->genre_id,
                'description' => $request->description,
                'price' => $request->price,
                'delivery_charge' => $delivery_charge,
                'method_of_shipment' => $method_of_shipment,
                'days_to_derivery' => $days_to_derivery,
            ]);
            
        return redirect()->route('posts.show', $post->id)->with('success', '投稿を編集しました');
        
    }
    
    public function editImage($id)
    {
        $post = Post::find($id);
        $post_images = $post->images()->get();
        
        if(\Auth::id() === $this->postUser($id)){
            $post = Post::find($id);
            return view('posts.edit_image', [
                'title' => '投稿画像の編集',
                'post' => $post,
                'post_images' => $post_images,
            ]);
        }
        
    }
    
    public function saveImage($id, PostImageRequest $request, FileUploadService $service)
    {
        $post = Post::find($id);
        $current_images = $post->images()->get();
        
        foreach($current_images as $current_image){
            if($current_image->image !== ''){
            \Storage::disk('public')->delete($current_image->image);
            }
            $current_image->delete();
        }
        
        $service->savePostImage($request->file('image'), $post->id);
        return redirect()->route('posts.show', $post->id)->with('success', '画像を変更しました'); 
        
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post_images = $post->images()->get();
        $comments = $post->comments();
        
        foreach($post_images as $post_image){
            if($post_image->image !== ''){
                \Storage::disk('public')->delete($post_image->image);
            }
            $post_image->delete();
        }
        
        $post->delete();
        $comments->delete();
        return redirect()->route('users.index')->with('success', '投稿を削除しました');
        
    }
    
    public function destroyImage($id)
    {
        $post_image = PostImage::find($id);
        $post_ids = $post_image->post_id;
        
        if($post_image->post->images()->count()<=1){
            return redirect()->route('posts.edit_image', $post_ids)->with('failure', '画像は１枚以上必要です');
        } elseif($post_image->image !== '') {
            \Storage::disk('public')->delete($post_image->image);
        }
        
        $post_image->delete();
        return redirect()->route('posts.edit_image', $post_ids)->with('success', '画像を削除しました'); 
        
    }
        
    private function toSellCheck($request)
    {
        $delivery_charge = ($request->delivery_charge === "1") ? true : false;
        $method_of_shipment = ($request->method_of_shipment === "1") ? true : false;
        $days_to_derivery = ($request->days_to_derivery === "1") ? true : false;
        
        return [$delivery_charge, $method_of_shipment, $days_to_derivery];
        
    }
    
    private function postUser($id)
    {
        $post = Post::find($id);
        if($post->user_id !== \Auth::id()){
            return redirect()->route('users.index')->with->flash('failure', '不正なアクセスです。');
        }
        
        return $post->user_id;
        
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Order;
use App\Post;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Services\FormCheckService;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function confirm($id, FormCheckService $service)
    {
        $post = Post::find($id);
        $post_images = $post->images()->get();
        list($delivery_charge_name, $method_of_shipment_name, $days_to_derivery_name) = $service->currentForm($id);
        
            return view('orders.confirm', [
                'title' => '購入確認',
                'post' => $post,
                'post_images' => $post_images,
                'delivery_charge_name' => $delivery_charge_name,
                'method_of_shipment_name' => $method_of_shipment_name,
                'days_to_derivery_name' => $days_to_derivery_name,
            ]);

    }
    
    public function store(OrderRequest $request, $id)
    {
        $post_id = $request->post_id;
        $orderd = Order::where('post_id', '=', $post_id)->count();
        
        if($orderd > 0) {
            return redirect()->route('posts.show', $post_id)->with('failure', '申し訳ありません。少し前に売り切れました。');
        } else {
            $order = Order::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
            ]);
            
        return redirect()->route('orders.finish', $order->post_id);
        
        }
    }
    
    public function show()
    {
        $ordered_posts = \Auth::user()->ordered_posts();
        
        return view('orders.show', [
            'title' => '購入一覧',
            'ordered_posts' => $ordered_posts,
        ]);
        
    }
    
    public function finish($id, FormCheckService $service)
    {
        $post = Post::find($id);
        $post_images = $post->images()->get();
        list($delivery_charge_name, $method_of_shipment_name, $days_to_derivery_name) = $service->currentForm($id);
        session()->flash('success', 'ご購入ありがとうございます！');

            return view('orders.finish', [
                'title' => '購入完了',
                'post' => $post,
                'post_images' => $post_images,
                'delivery_charge_name' => $delivery_charge_name,
                'method_of_shipment_name' => $method_of_shipment_name,
                'days_to_derivery_name' => $days_to_derivery_name,
            ]);
        
    }
}

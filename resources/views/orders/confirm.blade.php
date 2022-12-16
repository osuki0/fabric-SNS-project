@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <div class="show_wrapper">
            <div class="row-cols-sm-1">
                <div class="card">
                    
                <!-- Carousel -->
                    <div class="carousel carousel-dark" data-bs-ride="carousel" id="index" >
                        <div class="carousel-inner">
                        @foreach($post_images as $image_number => $post_image)
                            @if($image_number === 0)
                                <div class="carousel-item active">
                                    <img src="{{ \Storage::url($post_image->image) }}" class="show_card_img" alt="post_image">
                                </div>
                            @else
                                <div class="carousel-item">
                                    <img src="{{ \Storage::url($post_image->image) }}" class="show_card_img" alt="post_image">
                                </div>
                            @endif
                        @endforeach 
                        </div>
                        
                <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#index" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#index" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <h2>「 {!! nl2br(e($post->title)) !!} 」</h2>
                            <a href="{{ route('users.show', $post->user_id) }}">投稿者：{!! nl2br(e($post->user->name)) !!}さん</a>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        ジャンル：{{ $post->genre->name }}
                                    </li>
                                    <li class="list-group-item">
                                        {!! nl2br(e($post->description)) !!}
                                    </li>
                                    <li class="list-group-item">
                                        販売価格：{{ $post->price }} 円
                                    </li>
                                    <li class="list-group-item">
                                        配送料の負担：{{ $delivery_charge_name }}
                                    </li>
                                    <li class="list-group-item">
                                        配送方法：{{ $method_of_shipment_name }}
                                    </li>
                                    <li class="list-group-item">
                                        発送までの日数：{{ $days_to_derivery_name }}
                                    </li>
                                </ul>
                        <div class="card-footer">
                            <form method="POST" action="{{ route('orders.order_store', $post->id ) }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="submit" value="内容を確認し、購入する" class="btn btn-outline-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
@endsection

@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>

        <div class="show_wrapper">
            <div class="row-cols-sm-1">
                <div class="col">
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
                            @if(Auth::id() !== ($post->user_id))
                                <a href="{{ route('users.show', $post->user_id) }}">投稿者：{!! nl2br(e($post->user->name)) !!}さん</a>
                            @else
                                <h3>あなたの投稿です</h3>
                            @endif
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    ジャンル：{{ $post->genre->name }}
                                </li>
                                <li class="list-group-item">
                                    {!! nl2br(e($post->description)) !!}
                                </li>
                                <li class="list-group-item">
                                    投稿日：{!! nl2br(e($post->created_at)) !!}
                                </li>
                                
                            @if($post->price > 0 && $post->orders->count() === 0)
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
                            @endif
                            
                            </ul>
                        </div>
                        <div class="card-footer">
                            <ul>
                            @if(Auth::id() === ($post->user_id) && $post->orders->count() === 0)
                                <li>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-primary">記事の編集</a>
                                </li>
                                <li>
                                    <a href="{{ route('posts.edit_image', $post->id) }}" class="btn btn-outline-primary">写真の編集</a>
                                </li>
                                <li>
                                    <form class="delete" method="post" action="{{ route('posts.destroy', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除" class="btn btn-outline-danger">
                                    </form>
                                </li>
                            @endif
                            
                            @if(
                                Auth::id() !== ($post->user_id) 
                                && $post->price > 0
                                && $post->orders->count() === 0
                                && $not_entered === false
                                )
                                <li>
                                    <a href="{{ route('orders.confirm', $post->id) }}" class="btn btn-outline-primary">購入する</a>
                                </li>
                            @elseif(
                                    Auth::id() !== ($post->user_id) 
                                    && ($post->price > 0) 
                                    && $post->orders->count() === 0
                                    && $not_entered === true
                                    )
                                <li>
                                    <p class="info">このアイテムは個人情報を入力して購入可能です</p>
                                    <a href="{{ route('users.edit', Auth::id()) }}" class="btn btn-outline-primary">プロフィール入力</a>
                                </li>
                            @endif
                            
                            @if($post->orders->count() !== 0)
                                <li>
                                    <p>このアイテムは取引済みです</p>
                                </li>
                            @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="comments card">
                        <h2>コメント</h2>
                            <div class="card-body">
                                <ul>
                                    @forelse($post_comments as $comment)
                                    <div class="comments_area">
                                        <div><li>{{ $comment->user->name }}さん: {{ $comment->body }}（{{ $comment->created_at }}）</li></div>
                                        @if(Auth::id() === ($comment->user_id))
                                            <form class="delete" method="post" action="{{ route('comments.destroy', $comment->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="削除" class="btn btn-outline-danger btn-sm">
                                            </form>
                                        @endif
                                    </div>
                                    @empty
                                        <li>コメントはありません。</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div>
                               <form method="post" action="{{route('comments.store') }}">
                                @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="text" name="body" placeholder="200文字以内" >
                                    <input type="submit" class="btn btn-outline-primary btn-sm" value="送信">
                               </form>
                            </div>
                            <div class="comments_link">
                                {{ $post_comments->links() }}
                            </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
  
@endsection

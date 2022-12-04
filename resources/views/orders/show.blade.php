@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <div class="show_wrapper">
            <div class ="row-cols-sm-1">
                <div class="col">
                    <div class="card">
                        @forelse($ordered_posts as $ordered_post)
                            <div class="card">
                                <a href="{{ route('posts.show', $ordered_post) }}">
                                    <div class="row">
                                        <div class="row-cols-sm-1 col-md-4">
                                        @if($ordered_post->images->first()->image !== '')
                                            <img src="{{ \Storage::url($ordered_post->images->first()->image) }}" class="mini_card_img" alt="user_image">
                                        @else
                                            <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                        @endif
                                        </div>
                                        <div class="row-cols-sm-1 col-md-8">
                                            <div class="card-body">
                                                タイトル：{!! nl2br(e($ordered_post->title)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>購入した商品はありません。</p>
                        @endforelse
                 
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

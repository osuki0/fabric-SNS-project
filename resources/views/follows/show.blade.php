@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <div class="show_wrapper">
            <div class ="row-cols-sm-1">
                <div class="col">
                    <div class="card">
                        <h2>相互フォロワー</h2>
                        @forelse($follow_for_follows as $follow_for_follow)
                            <div class="card follow_card">
                                <a href="{{ route('users.show', $follow_for_follow) }}">
                                    <div class="row">
                                        <div class="row-cols-sm-1 col-md-4">
                                        @if($follow_for_follow->image !== '')
                                            <img src="{{ \Storage::url($follow_for_follow->image) }}" class="mini_card_img" alt="user_image">
                                        @else
                                            <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                        @endif
                                        </div>
                                        <div class="row-cols-sm-1 col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{!! nl2br(e($follow_for_follow->name)) !!} さん</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>相互フォローしているユーザーはいません。</p>
                        @endforelse
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <h2>あなたのフォローユーザー</h2>
                        @forelse($not_follow_users as $not_follow_user)
                            <div class="card follow_card">
                                <a href="{{ route('users.show', $not_follow_user) }}">
                                    <div class="row">
                                        <div class="row-cols-sm-1 col-md-4">
                                        @if($not_follow_user->image !== '')
                                            <img src="{{ \Storage::url($not_follow_user->image) }}" class="mini_card_img" alt="user_image">
                                        @else
                                            <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                        @endif
                                        </div>
                                        <div class="row-col-sm-1 col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{!! nl2br(e($not_follow_user->name)) !!} さん</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>相互フォロー以外のフォローユーザーはいません。</p>
                        @endforelse
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <h2>あなたのフォロワー</h2>
                        @forelse($not_followers as $not_follower)
                            <div class="card follow_card">
                                <a href="{{ route('users.show', $not_follower) }}">
                                    <div class="row">
                                        <div class="row-cols-sm-1 col-md-4">
                                        @if($not_follower->image !== '')
                                            <img src="{{ \Storage::url($not_follower->image) }}" class="mini_card_img" alt="user_image">
                                        @else
                                            <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                        @endif
                                        </div>
                                        <div class="row-cols-sm-1 col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{!! nl2br(e($not_follower->name)) !!} さん</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>未フォローのフォロワーはいません。</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

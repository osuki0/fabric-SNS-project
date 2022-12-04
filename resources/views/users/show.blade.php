@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <div class="show_wrapper">
            <div class="row-cols-sm-1">
                <div class="col">
                    <div class="card">
                    @if($user->image !== '')
                        <img src="{{ \Storage::url($user->image) }}" class="profile_card_img" alt="user_image">
                    @else
                        <img src="{{ asset('storage/images/no_image.png') }}" class="profile_card_img" alt="user_image">
                    @endif
                        <div class="card-body">
                            <div class="card-title">
                                <h3>{!! nl2br(e($user->name)) !!}さん</h3>
                                @if(Auth::id() !== ($user->id))
                                    <div class="follow_button">
                                    @if(Auth::user()->isFollowing($user))
                                        <form method="post" action="{{route('follows.destroy', $user)}}" class="follow">
                                            @csrf
                                            @method('delete')
                                            <input type="submit" value="フォロー解除"  class="btn btn-outline-danger">
                                        </form>
                                    @else
                                        <form method="post" action="{{route('follows.store')}}" class="follow">
                                            @csrf
                                            <input type="hidden" name="follow_id" value="{{ $user->id }}">
                                            <input type="submit" value="フォローする"  class="btn btn-outline-primary">
                                        </form>
                                    @endif
                                    </div>
                                    
                                @endif
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <dt>プロフィール</dt>
                                    @if($user->profile !== '')
                                        <dd>{!! nl2br(e($user->profile)) !!}</dd>
                                    @else
                                        <dd>プロフィールが設定されていません。</dd>
                                    @endif
                                </li>
                                
                            @if(Auth::id() === ($user->id))
                                <li class="list-group-item">
                                    <dt>お名前</dt>
                                        <dd>名字：{!! nl2br(e($user->last_name)) !!}</dd>
                                        <dd>名前：{!! nl2br(e($user->first_name)) !!}</dd>
                                </li>
                                <li class="list-group-item">
                                    <dt>電話番号</dt>
                                        <dd>{{ ($user->phone) }}</dd>
                                </li>
                                <li class="list-group-item">
                                    <dt>郵便番号</dt>
                                        <dd>{{ ($user->postal_code) }}</dd>
                                </li>
                                <li class="list-group-item">
                                    <dt>住所</dt>
                                        <dd>{!! nl2br(e($user->address)) !!}</dd>
                                </li>
                            @endif
                            
                            </ul>
                        </div>
                        <div class="card-footer">
                        @if(Auth::id() === ($user->id))
                            <ul>
                                <li>
                                    <a href="{{ route('users.edit', Auth::id()) }}" class="btn btn-outline-primary">プロフィールの編集</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.edit_image', Auth::id()) }}" class="btn btn-outline-primary">写真の編集</a>
                                </li>
                            </ul>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="col profile_list">
                    <h3>{{ ($user->name) }}さんの投稿</h3>
                    @forelse($user_posts as $user_post)
                        <div class="card">
                            <a href="{{ route('posts.show', $user_post->id) }}">
                                <div class="row">
                                    <div class="row-cols-sm-1 col-md-4">
                                    @if($user_post->images->first()->image !== '')
                                        <img src="{{ \Storage::url($user_post->images->first()->image) }}" class="mini_card_img" alt="user_image">
                                    @else
                                        <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                    @endif
                                    </div>
                                    <div class="row-cols-sm-1 col-md-8">
                                        <div class="card-body">
                                            <p>投稿タイトル：{!! nl2br(e($user_post->title)) !!}</p>
                                            <p>{!! nl2br(e($user_post->created_at)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>{{ ($user->name) }}さんの投稿はありません。</p>
                    @endforelse
                    {{ $user_posts->links() }}
                </div>
            </div>
        </div>
    </div>
  
@endsection
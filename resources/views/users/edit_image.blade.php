@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
        
        <div class="show_wrapper">
            <div class="row-cols-sm-1">
                <h2>{!! nl2br(e($user->name)) !!}さんのプロフィール画像</h2>
                @if($user->image !== '')
                    <img src="{{ \Storage::url($user->image) }}" class="edit_card_img" alt="user_image">
                @else
                    <img src="{{ asset('storage/images/no_image.png') }}" class="edit_card_img" alt="user_image">
                @endif
                    
                    <form method="POST" action="{{ route('users.update_image', Auth::id()) }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                            <div class="form_area">
                                <label for="user_image" class="form-label">画像の投稿</label>
                                <input class="form-control" type="file" id="user_image" name="image" >
                            </div>
                        <input type="submit" class="btn btn-primary" value="更新">
                    </form>
            </div>
        </div>
    </div>
    
@endsection
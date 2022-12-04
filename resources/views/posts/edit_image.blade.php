@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <form method="POST" action="{{ route('posts.save_image', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
            
            <div class="show_wrapper">
                <div class="row-cols-sm-1">
                    <h2>タイトル：{!! nl2br(e($post->title)) !!}</h2>
                        <div class="row g-2">
                            @foreach($post_images as $post_image)
                                <div class="col">
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#Modal">
                                        <img src="{{ \Storage::url($post_image->image) }}" class="show_card_img" alt="post_image">
                                    </button>
                                </div>
                            @endforeach
                            <div class="form_area">
                                <label for="post_image" class="form-label">画像の投稿(３枚まで登録できます)</label>
                                <input class="form-control" type="file" id="post_image" name="image[]" multiple>
                            </div>
                        </div>
                </div>
                <input type="submit" class="btn btn-primary" value="更新">
            </div>
        </form>

        @foreach($post_images as $post_image)
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">確認</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">この画像を削除しますか？</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>
                            <form class="delete" method="post" action="{{ route('posts.destroy_image', $post_image->id) }}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="削除" class="btn btn-outline-danger">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    
@endsection
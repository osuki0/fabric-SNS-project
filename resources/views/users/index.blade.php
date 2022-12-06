@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
    <!-- Carousel -->
    <div class="carousel carousel-dark" data-bs-ride="carousel" id="index">

    <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#index" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#index" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#index" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#index" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#index" data-bs-slide-to="4"></button>
        </div>
  
    <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('storage/carousel/carousel0.jpeg') }}" alt="first_carousel" class="index_carousel d-block" loading="lazy">
                <div class="carousel-caption bg-light bg-opacity-75">
                    <h2>あおぞらFablic</h2>
                        <p>あなたの自慢の布をお披露目するSNS</p>
                        <p>Pleas find one of your favorite fablics!</p>
                </div>
            </div>
        @foreach($carousel_posts as $carousel_post)
            <div class="carousel-item">
                <a href="{{ route('posts.show', $carousel_post->id) }}">
                    <img src="{{ \Storage::url($carousel_post->images->first()->image) }}" alt="index_carousel" class="index_carousel d-block" loading="lazy">
                    <div class="carousel-caption bg-light bg-opacity-75">
                        <h2>{{ $carousel_post->title }}</h2>
                            <p>あなたの自慢の布をお披露目するSNS</p>
                            <p>Pleas find one of your favorite fablics!</p>
                    </div>
                </a>
            </div>
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
    
    <!-- Search -->
    <form method="GET" action="{{ route('users.index') }}">
        <div class="search_form row">
            <div class="search col-auto">
                <input type="search" class="form-control" name="keyword" placeholder="みんなの投稿を探そう" value="{{ $keyword }}">
            </div>
            <div class="search col-auto">
                <input type="submit" class="btn btn-primary" value="検索">
            </div>
        </div>
    </form>

    <!-- Recommend -->
    <div class="recommend_area">
        <h3>{{ $user->name }}さんへの おすすめユーザー</h3>
            <ul class="recommend_users">
            @forelse($recommended_users as $recommended_user)
                <li>
                    <a href="{{ route('users.show', $recommended_user) }}">{{ $recommended_user->name }}さん</a>
                </li>
            @empty
                <li>おすすめユーザーはいません。</li>
            @endforelse
            </ul>
    </div>

    <!-- Contents -->
    <div class="container">
        <div class="row index">
            <div class="col-lg-9">
                <ul class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-4" id="ul"></ul>
            </div>
            <div class="col-lg-3">
                <div class="card sidebar">
                    <div class="card index_profile">
                        <a href="{{ route('users.show', $user->id) }}">
                        @if($user->image !== '')
                            <img src="{{ \Storage::url($user->image) }}" class="card_img" alt="user_image">
                        @else
                            <img src="{{ asset('storage/images/no_image.png') }}" class="card_img" alt="user_image">
                        @endif
                        </a>
                        <div class="card-body">
                            <h3 class="card-title">{!! nl2br(e($user->name)) !!}さん</h3>
                            <div class="card-text">
                                <p>{!! nl2br(e($user->profile)) !!}</p>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li>
                                        <a href="{{ route('posts.create') }}" class="btn btn-outline-primary btn-sm">新規投稿</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-primary btn-sm">編集</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card user_posts">
                        <h3>{{ $user->name }}さんの新着投稿</h3>
                        @forelse($user_posts as $user_post)
                            <div class="card">
                                <a href="{{ route('posts.show', $user_post->id) }}">
                                    <div class="row">
                                        <div class="row-cols-sm-1 col-md-6">
                                        @if($user_post->images->first()->image !== '')
                                            <img src="{{ \Storage::url($user_post->images->first()->image) }}" class="mini_card_img" alt="user_image">
                                        @else
                                            <img src="{{ asset('storage/images/no_image.png') }}" class="mini_card_img" alt="user_image">
                                        @endif
                                        </div>
                                        <div class="row-cols-sm-1 col-md-6">
                                            <div class="card-body">
                                                <p>{!! nl2br(e($user_post->title)) !!} </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>{{ ($user->name) }}さんの投稿はありません。</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
    <!-- posts getJson -->
        <script>
        
            let counter;
            let timeoutId;

            window.addEventListener('load', () => {
                counter = 0;
                getPosts();
            });
            
            $(window).scroll(function () {
                if(700 < window.scrollY){
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function () {
                        getPosts();
                    }, 200);
                }
            });
                    
            const getPosts = () => {
                $.ajax({
                    url:'{{ route('getJson') }}',
                    method: 'GET',
                    data: {offset: counter, keyword: '{{$keyword}}'},
                    dataType:'JSON'
                }).done((res)=> {
                    postsShow(res);
                }).fail(() => {
                    console.log("投稿取得に失敗しました。");
                });
            };
                    
            const postsShow = (datas) => {
                let boxes = [];
                boxes = datas.map((x)=> {
                    let li_col = $('<li>');
                    li_col.addClass('col');
                    
                    let card = $('<div>');
                    card.addClass('card');
                    
                    let img = $('<img>');
                    img.addClass('card_img');
                    img.attr('src', '/storage/'+ x.images[0].image);
                    img.attr('alt', 'post_image');
                    img.attr('loading','lazy');
                            
                    let cardBody = $('<div>');
                    cardBody.addClass('card-body');
                    
                    let cardTitle = $('<div>');
                    cardTitle.addClass('card-title');
                    let title = $('<p>');
                    title.html(x.title);
                            
                    let cardText = $('<div>');
                    cardText.addClass('card-text');
                    let cardText_p = $('<p>');
                    cardText_p.html(x.description);
                            
                    let cardFooter = $('<div>');
                    cardFooter.addClass('card-footer');
                    let cardFooter_ul = $('<ul>');
                    cardFooter_ul.addClass('list-group list-group-flush');
                    let cardFooter_li_name = $('<li>');
                    cardFooter_li_name.addClass('list-group-item');
                    cardFooter_li_name.html('投稿者：'+x.user.name);
                    let cardFooter_li_genre = $('<li>');
                    cardFooter_li_genre.addClass('list-group-item');
                    cardFooter_li_genre.html('ジャンル：'+ x.genre.name);
                    let cardFooter_li_creat = $('<li>');
                    cardFooter_li_creat.addClass('list-group-item');
                    cardFooter_li_creat.html(x.created_at);
                    let cardFooter_li_a = $('<li>');
                    let a = $('<a>');
                    a.attr('href', '/posts/'+ x.id);
                    a.addClass('stretched-link');
                    
                    cardTitle.append(title);
                    cardText.append(cardText_p);
                    
                    cardFooter_ul.append(cardFooter_li_name);
                    cardFooter_ul.append(cardFooter_li_genre);
                    cardFooter_ul.append(cardFooter_li_creat);
                    cardFooter_ul.append(cardFooter_li_a);
                    cardFooter_li_a.append(a);
                    cardFooter.append(cardFooter_ul);
                    
                    cardBody.append(cardTitle);
                    cardBody.append(cardText);
                    cardBody.append(cardFooter);
                    
                    card.append(img); 
                    card.append(cardBody);
                    
                    li_col.append(card);
                    
                    return li_col;
                })
                
                for(let box of boxes){
                    $('#ul').append(box);
                }
                counter += boxes.length;
            }
            
        </script>
    </div>

@endsection

@extends('layouts.default')
 
@section('header')
    <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('users.index') }}">あおぞら</br>Fablic</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.create') }}">新規投稿</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('follows.show', Auth::id()) }}">お気に入りユーザー</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.show', Auth::id()) }}">プロフィール</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.show', Auth::id()) }}">購入一覧</a>
                        </li>
                    </ul>
                    <form action="{{ route('logout', Auth::id()) }}" method="POST">
                        @csrf
                            <input type="submit" value="ログアウト" class="button_logout">
                    </form>
                </div>
            </div>
        </nav>
    </header>
@endsection
 
@section('footer')
    <footer class="footer bg-dark">
        <div class="container">
            <p class="text-muted">あおぞらFablic©︎ All Rights Reserve</p>
        </div>
    </footer>
@endsection

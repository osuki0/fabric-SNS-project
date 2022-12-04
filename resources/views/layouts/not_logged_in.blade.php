@extends('layouts.default')
 
@section('header')
    <header>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">サインアップ</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
            </li>
        </ul>
    </header>
@endsection
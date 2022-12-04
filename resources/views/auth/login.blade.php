@extends('layouts.not_logged_in')
 
@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class ="login_wrapper">
            <p>テストユーザー様（お名前：test、パスワード：Test1234）</p>
            <div class="form_signin">
                <div class="form_signin_heading">
                    <h3>あおぞらFablic</h3>
                    <p>あなたの自慢の布をお披露目するSNS</p>
                    <p>Welcome Log In!</p>
                </div>
                
                <div class="form_area">
                    <input type="text" class="form-control" name="name" placeholder="お名前" value="{{ old("name") }}">
                </div>

                <div class="form_area">
                    <input type="password" class="form-control" name="password" placeholder="パスワード">
                </div>
                
                <button type="submit" class="btn btn-primary" name="submit">ログイン</button>
            </div>
        </div>
    </form>
    
@endsection
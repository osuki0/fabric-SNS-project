@extends('layouts.not_logged_in')
 
@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class ="login_wrapper">
            <div class="form_signin">
                <div class="form_signin_heading">
                    <h3>あおぞらFablic</h3>
                    <p>あなたの自慢の布をお披露目するSNS</p>
                    <p>Please Sing up!</p>
                </div>
            
                <div class="form_area">
                    <input type="text" class="form-control" name="name" placeholder="お名前（10文字以内）" value="{{ old("name") }}">
                </div>

                <div class="form_area">
                    <input type="email" class="form-control" name="email" placeholder="メールアドレス" value="{{ old("email") }}">
                </div>

                <div class="form_area">
                    <input type="password" class="form-control" name="password" placeholder="パスワード">
                    <p class="password_attention">半角英数字(A~Z,a~z,0~9,ハイフン)を最低１つずつ含めた8文字以上24文字以内</p>
                </div>
                
                <div class="form_area">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="パスワード（確認用）">
                </div>
                
                <button type="submit" class="btn btn-primary" name="submit">登録</button>
            </div>
        </div>
    </form>

@endsection

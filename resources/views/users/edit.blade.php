@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{!! nl2br(e($user->name)) !!}さんの{{ $title }}</h1>
    
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            
            <div class="show_wrapper">
                <div class="row-cols-sm-1">
                    <div class="form_area">
                        <label for="profile" class="form-label">プロフィール</label>
                        <textarea class="textarea form-control" name="profile" id="profile" rows="3">{{ old("profile", $user->profile) }}</textarea>
                    </div>

                    <div class="form_area fullname">
                        <div class="name_area">
                            <label for="last_name" class="form-label">名字</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old("last_name", $user->last_name) }}">
                        </div>
                        <div class="name_area">
                            <label for="first_name" class="form-label">名前</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old("first_name", $user->first_name) }}">
                        </div>
                    </div>

                    <div class="form_area">
                        <label for="phone" class="form-label">電話番号</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old("phone", $user->phone) }}">
                    </div>

                    <div class="form_area">
                        <label for="postal_code" class="form-label">郵便番号</label>
                        <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{ old("postal_code", $user->postal_code) }}">
                    </div>
                
                    <div class="form_area">
                        <label for="address" class="form-label">住所</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ old("address", $user->address) }}">
                    </div>
                </div>
            <input type="submit" class="btn btn-primary" value="更新">
            </div>
        </form>
    </div>
  
@endsection

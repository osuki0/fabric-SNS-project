@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
    
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
            
            <div class="show_wrapper">
                <div class="row-cols-sm-1">
                    <div class="form_area">
                        <label for="post_title" class="form-label">タイトル</label>
                        <input type="text" class="form-control" name="title" id="post_title" value="{{ old("title", $post->title) }}">
                    </div>
            
                    <div class="form_area">
                        <label for="post_genre" class="form-label">ジャンル</label>
                        <select type="text" class="form-select genre_id" name="genre_id">
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" @if($genre->id === $this_genre) selected @endif>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                        
                    <div class="form_area">
                        <label for="post_description" class="form-label">紹介文</label>
                        <textarea class="textarea form-control" name="description" id="post_description" rows="8">{{ old("description", $post->description) }}</textarea>
                    </div>
                    
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input btn-lg" id="to_sell">
                        <label for="login_check" class="form-check-label">販売する</label>
                    </div>
                
                    <div class="form_area sell_area">
                        <label for="post_price" class="form-label">販売価格（円）</label>
                        <input type="text" class="form-control" name="price" id="post_price" value="{{ old("price", $post->price) }}">
                    </div>
                
                    <div class="form_area sell_area">
                        <label for="delivery_charge" class="form-label">配送料の負担</label>
                        <select type="text" class="form-select" name="delivery_charge" id="delivery_charge">
                            <option @if($post->delivery_charge === 0) value="{{ $post->delivery_charge }}" selected @endif>送料込み（出品者負担）</option>
                            <option @if($post->delivery_charge === 1) value="{{ $post->delivery_charge }}" selected @endif>着払い（購入者負担）</option>
                        </select>
                    </div>
                    
                    <div class="form_area sell_area">
                        <label for="method_of_shipment" class="form-label">配送方法</label>
                        <select type="text" class="form-select" name="method_of_shipment" id="method_of_shipment">
                            <option @if($post->method_of_shipment === 0) value="{{ $post->method_of_shipment }}" selected @endif>メール便</option>
                            <option @if($post->method_of_shipment === 1) value="{{ $post->method_of_shipment }}" selected @endif>宅配便</option>
                        </select>
                    </div>
                    
                    <div class="form_area sell_area">
                        <label for="days_to_derivery" class="form-label">発送までの日数</label>
                        <select type="text" class="form-select" name="days_to_derivery" id="days_to_derivery">
                            <option @if($post->days_to_derivery === 0) value="{{ $post->days_to_derivery }}" selected @endif>1~3日で発送</option>
                            <option @if($post->days_to_derivery === 1) value="{{ $post->days_to_derivery }}" selected @endif>4~7日で発送</option>
                        </select>
                    </div>
                </div>
            <script>
            
                const hideSellArea = () => {
                    let sellAreas = document.getElementsByClassName('sell_area');
                    for(let sellArea of Array.from(sellAreas)){
                        sellArea.style.display='none';
                    }
                }

                const showSellArea = () => {
                    let sellAreas = document.getElementsByClassName('sell_area');
                    for(let sellArea of Array.from(sellAreas)){
                        sellArea.style.display='block';
                    }
                    document.getElementById('to_sell').checked = true;
                }
                
                hideSellArea();
                
                if(Number(document.getElementById('post_price').value) > 0){
                    showSellArea();
                }
                
                let toSell = document.getElementById('to_sell');
                 toSell.addEventListener('change',(e)=>{
                     if(e.target.checked){
                         showSellArea();
                     }else{
                         hideSellArea();
                     }
                 })
                 
            </script>
            <input type="submit" class="btn btn-primary" value="更新">
            </div>
        </form>
    </div>
    
@endsection
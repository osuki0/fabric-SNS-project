@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

    <div class="wrapper">
    <h1>{{ $title }}</h1>
        
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        
            <div class="show_wrapper">
                <div class="row-cols-sm-1">
                    <div class="form_area">
                        <label for="post_title" class="form-label">タイトル（必須）</label>
                        <input type="text" class="form-control" name="title" id="post_title" placeholder="20文字以内" value="{{ old("title") }}">
                    </div>
                    
                    <div class="form_area">
                        <label for="post_genre" class="form-label">ジャンル（必須）</label>
                        <select type="text" class="form-select genre_id" name="genre_id" id="post_genre" value="{{ old("genre_id") }}">
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form_area">
                        <label for="post_image" class="form-label">画像の投稿(必須：３枚まで登録できます)</label>
                        <input class="form-control" type="file" id="post_image" name="image[]" multiple>
                    </div>
                    
                    <div class="form_area">
                        <label for="post_description" class="form-label">紹介文（必須）</label>
                        <textarea class="textarea form-control" name="description" id="post_description" rows="8" value="{{ old("description") }}">記入例&#13;&#10;購入場所：&#13;&#10;大きさ：</textarea>
                    </div>
                
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input btn-lg" id="to_sell">
                        <label for="login_check" class="form-check-label">販売する</label>
                    </div>
                
                    <div class="form_area sell_area">
                        <label for="post_price" class="form-label">販売価格（円）</label>
                        <input type="text" class="form-control" name="price" id="post_price" placeholder="販売する場合は価格を設定してください（300円〜1,000,000円）" value="{{ old("price") }}">
                    </div>
                    
                    <div class="form_area sell_area">
                        <label for="delivery_charge" class="form-label">配送料の負担</label>
                        <select type="text" class="form-select" name="delivery_charge" id="delivery_charge" value="{{ old("delivery_charge") }}">
                            <option value="0">送料込み（出品者負担）</option>
                            <option value="1">着払い（購入者負担）</option>
                        </select>
                    </div>
                    
                    <div class="form_area sell_area">
                        <label for="method_of_shipment" class="form-label">配送方法</label>
                        <select type="text" class="form-select" name="method_of_shipment" id="method_of_shipment" value="{{ old("method_of_shipment") }}">
                            <option value="0">メール便</option>
                            <option value="1">宅配便</option>
                        </select>
                    </div>
                    
                    <div class="form_area sell_area">
                        <label for="days_to_derivery" class="form-label">発送までの日数</label>
                        <select type="text" class="form-select" name="days_to_derivery" id="days_to_derivery" value="{{ old("days_to_derivery") }}">
                            <option value="0">1~3日で発送</option>
                            <option value="1">4~7日で発送</option>
                        </select>
                    </div>
                </div>
            <script>
            
                const hideSellArea = () =>{
                    let sellAreas = document.getElementsByClassName("sell_area");
                    for(let sellArea of Array.from(sellAreas)){
                        sellArea.style.display="none";
                    }
                }

                const showSellArea = () =>{
                    let sellAreas = document.getElementsByClassName("sell_area");
                    for(let sellArea of Array.from(sellAreas)){
                        sellArea.style.display="block";
                    }
                }
                
                hideSellArea();
                
                let toSell = document.getElementById("to_sell");
                toSell.addEventListener("change",(e)=>{
                    if(e.target.checked){
                        showSellArea();
                    } else {
                        hideSellArea();
                    }
                })

            </script>
            <input type="submit" class="btn btn-primary" name="submit" value="投稿する">
            </div>
        </form>
    </div>
    
@endsection

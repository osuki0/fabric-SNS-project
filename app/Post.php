<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'genre_id', 'image[]', 'description', 'price', 'delivery_charge', 'method_of_shipment', 'days_to_derivery'
    ];
    
    public function scopeRecommendPosts($query, $self_id){
        return $query->where('user_id','<>', $self_id)->inRandomOrder()->limit(3)->get();
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function genre(){
        return $this->belongsTo('App\Genre');
    }
    
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
    public function order_count($id){
        return Order::all()->where('post_id', '$id')->count(); 
    }
    
    public function comments(){
      return $this->hasMany('App\Comment');
    }
    
    public function images(){
        return $this->hasMany('App\PostImage');
    }
    
}

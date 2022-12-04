<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'profile', 'first_name', 'last_name', 'first_name', 'phone', 'postal_code', 'address', 'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts(){
        return $this->hasMany('App\Post');
    }
    
    public function follows(){
        return $this->hasMany('App\Follow');
    }

    public function follow_users(){
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follow_id');
    }
 
    public function followers(){
        return $this->belongsToMany('App\User', 'follows', 'follow_id', 'user_id');
    }
    
    public function follow_for_follow(){
        $my_follower_id = $this->follow_users->pluck('id');
        $follow_for_follow = $this->followers->whereIn('id', $my_follower_id);
        return $follow_for_follow;
    }
    
    public function not_follow_users(){
        $fff_ids = \Auth::user()->follow_for_follow()->pluck('id');
        $yet_fff_follow_users = \Auth::user()->follow_users->whereNotIn('id', $fff_ids);
        return $yet_fff_follow_users;
    }
    
    public function not_follower(){
        $fff_ids = \Auth::user()->follow_for_follow()->pluck('id');
        $yet_fff_follower = \Auth::user()->followers->whereNotIn('id', $fff_ids);
        return $yet_fff_follower;
    }
    
    public function isFollowing($user){
        $result = $this->follow_users->pluck('id')->contains($user->id);
        return $result;
    }
    
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
    public function ordered_posts(){
        $post_id = $this->orders->pluck('post_id');
        return Post::all()->whereIn('id', $post_id);
    }

    public function recommended_users(){
        $follow_user_ids = $this->follow_users->pluck('id')->toArray();
        $follow_user_ids[] = \Auth::id();
        $recommended_users = User::whereNotIn('id', $follow_user_ids)->inRandomOrder()->limit(4)->get();
        return $recommended_users;
    }

}

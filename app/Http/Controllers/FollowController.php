<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show()
    {
        $not_follow_users = \Auth::user()->not_follow_users();
        $not_followers = \Auth::user()->not_follower();
        $follow_for_follows = \Auth::user()->follow_for_follow();
        
        return view('follows.show', [
            'title' => 'お気に入りユーザー',
            'not_follow_users' => $not_follow_users,
            'not_followers' => $not_followers,
            'follow_for_follows' => $follow_for_follows,
        ]);
        
    }
    
    public function store(Request $request)
    {
        $user = \Auth::user();
        $follow = Follow::create([
            'user_id' => $user->id,
            'follow_id' => $request->follow_id,
        ]);
        
        return redirect()->route('users.show', $follow->follow_id)->with('success', 'フォローしました');
        
    }
 
    public function destroy($id)
    {
        $follow = \Auth::user()->follows->where('follow_id', $id)->first();
        $follow->delete();
        
        return redirect()->route('users.show', $follow->follow_id)->with('success', 'フォロー解除しました');
        
    }
 
}

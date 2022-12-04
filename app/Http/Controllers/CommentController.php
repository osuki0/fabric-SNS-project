<?php

namespace App\Http\Controllers;

use App\Comment; 
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request){
        Comment::create([
            'post_id'   => $request->post_id,
            'user_id' => \Auth::user()->id,
            'body' => $request->body,
        ]);
        
        return redirect()->route('posts.show', $request->post_id)->with('success', 'コメントを投稿しました');
    }
    
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_id = $comment->post_id;
        $comment->delete();
        
        return redirect()->route('posts.show', $post_id)->with('success', 'コメントを削除しました');
        
    }
    
}

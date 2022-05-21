<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Validator;

class PostController extends Controller
{
    public function createComment($post_id, Request $request) {
        $validator = Validator::make($request->all(), ['name' => 'required', 'comment_text'=>'required']);
        if ($validator->fails()){
            return response()->json('Error', 400);
        }
        $comment = Comment::create([
            'post_id'=>$post_id,
            'name'=>$request->name,
            'comment_text'=>$request->comment_text,
            'comment_replied_id'=>$request->comment_replied_id ?? null,
        ]);
        return response()->json($comment, 200);
    }
    public function getComments($post_id) {
        $comments = Comment::with('replies.replies')->where('post_id',$post_id)
        ->where('comment_replied_id',null)
        ->orderBy('created_at','desc')
        ->get();
        return response()->json($comments, 200);
    }
}

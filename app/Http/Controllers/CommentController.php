<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function comment(Request $request)
    {
        $action = $request['action'];
        switch ($action) {
            case 'create':
                $data = $request->only(['movie_id', 'user_id', 'content', 'comment_id']);
                $comment = new Comment();
                $comment->fill($data)->save();
                $user = User::find($comment->user_id);
                broadcast(new \App\Events\MessagePosted($comment, $user))->toOthers();
                break;
            case 'update':
                $data = $request->only(['id', 'content']);
                $comment = Comment::find($data['id']);
                $comment->fill($data)->save();
                $user = User::find($comment->user_id);
                broadcast(new \App\Events\MessagePosted($comment, $user))->toOthers();
                break;
            case 'delete':
                $data = $request->only(['id','status']);
                $data['content'] = Comment::status[$data['status']];
                $comment = Comment::find($data['id']);
                $comment->fill($data)->save();
                $user = User::find($comment->user_id);
                broadcast(new \App\Events\MessagePosted($comment, $user))->toOthers();
                break;
        }
        return response()->json(
            [
                'status' => 'success',
            ], Response::HTTP_OK);
    }

    public function listComment($id, $record)
    {
        $comments = Comment::listComments($id, $record);
        return response()->json(
            [
                'status' => 'success',
                'data' => $comments
            ], Response::HTTP_OK);
    }


    public function listChildComment($comment_id, $record)
    {
        $comments = Comment::listChildComments($comment_id, $record);
        return response()->json(
            [
                'status' => 'success',
                'data' => $comments
            ], Response::HTTP_OK);
    }
}

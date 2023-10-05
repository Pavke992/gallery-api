<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function store(StoreCommentRequest $request, $gallery_id)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $gallery = Gallery::findOrFail($gallery_id);

            if (!$gallery) {
                return response()->json(['message' => 'Gallery not found'], 404);
            }

            // Create comment
            $comment = new Comment();
            $comment->owner_id = $user->id;
            $comment->body = $request->input('body');

            // Connecting comment with gallery
            $gallery->comments()->save($comment);

            return response()->json($comment);
        } else {
            return response()->json(['message' => 'You are not logged in'], 401);
        }
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        return $comment->delete();
    }
}

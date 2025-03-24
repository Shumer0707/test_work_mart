<?php

namespace App\Services;

use App\Models\Comment;
use App\Http\Requests\SortCommentsRequest;

class CommentService
{
    public function getComments(SortCommentsRequest $request)
    {
        $query = Comment::with('user')->withCount('likes');

        switch ($request->sortField()) {
            case 'user':
                $query->join('users', 'comments.user_id', '=', 'users.id')
                      ->orderBy('users.name', $request->sortOrder())
                      ->select('comments.*'); // чтобы не потерять поля comments.*
                break;

            case 'likes':
                $query->orderBy('likes_count', $request->sortOrder());
                break;

            case 'date':
            default:
                $query->orderBy('created_at', $request->sortOrder());
                break;
        }

        return $query->paginate(10);
    }
}

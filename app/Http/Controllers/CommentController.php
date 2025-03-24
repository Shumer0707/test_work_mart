<?php

namespace App\Http\Controllers;

use App\Http\Requests\SortCommentsRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function index(SortCommentsRequest $request)
    {
        $comments = $this->commentService->getComments($request);
        return CommentResource::collection($comments);
    }
}

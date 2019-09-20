<?php

namespace Rulla\Http\Controllers\Comment;

use Illuminate\Http\Response;
use Rulla\Comments\Comment;
use Rulla\Http\Controllers\Controller;
use Rulla\Http\Requests\MakeCommentRequest;

class CommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param MakeCommentRequest $request
     * @return Response
     */
    public function __invoke(MakeCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return redirect($comment->commentable->viewUrl);
    }
}

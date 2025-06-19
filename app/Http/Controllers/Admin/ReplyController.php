<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reply;
use Illuminate\View\View;

class ReplyController extends Controller
{
    /**
     * Display a listing of the replies.
     *
     * @return View
     */
    public function index(): View
    {
        // 获取所有回复
        $replies = Reply::with('user', 'topic')->latest()->paginate($this->perPage);

        return view('admin.replies.index', compact('replies'));
    }
}

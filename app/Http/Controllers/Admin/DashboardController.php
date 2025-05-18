<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\PostResource;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Post::with(['author', 'category', 'tags'])->latest();

        if ($request->filled('status')) {
            switch ($request->status) {
                case PostStatus::PUBLISHED->value:
                    $query->published();
                    break;
                case PostStatus::UNPUBLISHED->value:
                    $query->unpublished();
                    break;
                case PostStatus::ARCHIVED->value:
                    $query->archived();
                    break;
            }
        }

        $posts = $query->paginate(9)->withQueryString();

        return Inertia::render('Dashboard', [
            'posts' => PostResource::collection($posts),
            'filters' => $request->only('status'),
        ]);
    }
}


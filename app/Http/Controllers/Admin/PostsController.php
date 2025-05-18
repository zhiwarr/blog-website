<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\UserResoruce;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'category', 'tags'])
            ->latest()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Admin/Posts/Index', [
            'posts' => PostResource::collection($posts)
        ]);
    }

    public function create()
    {
        $categories = CategoryResource::collection(Category::latest()->get());
        $authors =    UserResoruce::collection(User::where('role', Role::Author->value)->withCount('posts')->paginate(10));
        $tags = TagResource::collection(Tag::latest()->get());
        return Inertia::render('Admin/Posts/Form',[
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags
        ]);
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        $post = Post::create($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = CategoryResource::collection(Category::latest()->get());
        $authors = UserResoruce::collection(
            User::where('role', Role::Author->value)
                ->withCount('posts')
                ->paginate(10)
        );
        $tags = TagResource::collection(Tag::latest()->get());

        return Inertia::render('Admin/Posts/Form', [
            'post' => $post->load('tags'),
            'categories' => $categories,
            'authors' => $authors,
            'tags' => $tags
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }
        else{
        $validated['thumbnail'] = $post->thumbnail;
        }
        $validated['slug'] = Str::slug($validated['title']);

        $post->update($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

}

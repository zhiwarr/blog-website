<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'thumbnail',
        'category_id',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    #[Scope]
    public function published($query)
    {
        return $query->where('status', PostStatus::PUBLISHED);
    }

    #[Scope]
    public function unpublished($query)
    {
        return $query->where('status', PostStatus::UNPUBLISHED);
    }

    #[Scope]
    public function archived($query)
    {
        return $query->onlyTrashed();
    }
}

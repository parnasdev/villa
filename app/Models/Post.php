<?php

namespace App\Models;

use App\Models\Extra\{WithComment, WithPostFile, WithVisit};
use Cviebrock\EloquentSluggable\{Sluggable, SluggableScopeHelpers};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable, SluggableScopeHelpers, WithVisit, WithComment, WithPostFile;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'body',
        'options',
        'pin',
        'comment',
        'post_type',
        'status_id',
    ];


    protected $casts = [
        'pin' => 'boolean',
        'comment' => 'boolean',
        'options' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_post');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'پنهان شده',
            'family' => ''
        ]);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function path()
    {
        return '/' . $this->post_type . '/' . $this->slug;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Post $post) { // before delete() method call this
            if ($post->isForceDeleting()) {
                $post->files()->delete();
                $post->categories()->detach();
                $post->tags()->detach();
                if (function_exists('seasons')) {
                    $post->seasons()->delete();
                }
                if (function_exists('episodes')) {
                    $post->episodes()->delete();
                }

                if (function_exists('learnings')) {
                    $post->learnings()->delete();
                }
            }
            // do the rest of the cleanup...
        });
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where("title", 'regexp', '(^|[[:space:]])' . $keyword . '([[:space:]]|$)');
    }
}

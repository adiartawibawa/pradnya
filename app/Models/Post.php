<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\View;
use App\Models\Topic;
use App\Models\Visit;
use DateTimeInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'created_at',
        'publish_date',
    ];

    protected $appends = ['featured_image_url'];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * The post author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M, d Y');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return Storage::url('posts/' . $this->id . '/featured_image/' . $this->featured_image);
    }

    /**
     * Get the tags relationship.
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'posts_tags',
            'post_id',
            'tag_id'
        );
    }

    /**
     * Get the topic relationship.
     *
     * @return BelongsToMany
     */
    public function topic(): BelongsToMany
    {
        // TODO: This should be a belongsTo() relationship?
        return $this->belongsToMany(
            Topic::class,
            'posts_topics',
            'post_id',
            'topic_id'
        );
    }

    /**
     * Get the views relationship.
     *
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * Get the visits relationship.
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Check to see if the post is published.
     *
     * @return bool
     */
    public function getPublishedAttribute(): bool
    {
        return !is_null($this->published_at) && $this->published_at <= now()->toDateTimeString();
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now()->toDateTimeString());
    }

    /**
     * Scope a query to only include drafted posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('published_at', '=', null)->orWhere('published_at', '>', now()->toDateTimeString());
    }
}

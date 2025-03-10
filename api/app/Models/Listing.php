<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopePublished(Builder $query)
    {
        $query->where('published', true);
    }

    public function scopeAccepted(Builder $query)
    {
        $query->where('accepted', true);
    }

    public function scopeShouldPublish(Builder $query)
    {
        $query
            ->accepted()
            ->where('published', false)
            ->where('publish_at', '<=', now());
    }
}

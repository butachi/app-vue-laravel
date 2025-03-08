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

    public function publish(): void
    {
        if ($this->accepted) {
            throw new Exception('Listing is not accepted yet');
        }

        $this->publish_at = now();
        $this->published = true;
        $this->save();
    }

    public function accept(): void
    {
        $this->accepted = true;

        $this->accepted_at = now();

        if (!$this->publish_at || $this->publish_at->isPast()) {
            $this->publish();
        }

        $this->save();
    }

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

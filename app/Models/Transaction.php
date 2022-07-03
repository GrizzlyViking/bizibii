<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $account_id
 * @property \App\Enums\Category $category
 * @property float $amount
 * @property string $description
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 *
 * @property \App\Models\Account $account
 * @property Collection<\App\Models\Tag> $tags
 */
class Transaction extends Model
{

    use HasFactory;

    protected $casts = [
        'category' => Category::class,
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @param  \Illuminate\Support\Collection<\App\Enums\Tag>  $tags
     *
     * @return void
     */
    public function addTags(Collection $tags)
    {
        $tags->map(function (\App\Enums\Tag $tag) {
            return Tag::create([
                'type' => $tag,
                'taggable_type' => Transaction::class,
                'taggable_id' => $this->id,
            ]);
        });
    }

}

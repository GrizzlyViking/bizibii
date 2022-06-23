<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class Section
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $slug
 * @property int $page_id
 * @property Page $page
 * @property string $content
 * @property boolean $published
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Section extends Model implements ListableInterface
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'page_id',
        'content',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getColumn1(): string
    {
        return $this->title;
    }

    public function getColumn1Sub(): string
    {
        return $this->subtitle;
    }

    public function getColumn2(): string
    {
        return $this->slug;
    }

    public function getColumn3(): string
    {
        return $this->page->slug;
    }

    public function getColumn4(int $char_limit = 20): string
    {
        return Str::limit($this->content, $char_limit);
    }

    public function getRouteShow(): string
    {
        return route('section.show', [$this->page->slug, $this->slug]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Article
 * @package App\Models
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $author_id
 * @property bool $publish
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 * @property User $author
 *
 * @method Article updateOrCreate(array $attributes, array $values)
 */
class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'publish' => 'bool'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}

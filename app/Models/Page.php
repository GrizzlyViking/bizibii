<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Page
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property array $access
 * @property boolean $published
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property Carbon $deleted_at
 */
class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'published', 'access'
    ];

    protected $casts = [
        'access' => 'array'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}

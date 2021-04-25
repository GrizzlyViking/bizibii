<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
class Section extends Model
{
    use HasFactory, SoftDeletes;

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

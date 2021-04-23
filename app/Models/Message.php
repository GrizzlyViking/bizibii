<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Message
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property boolean $read
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property Carbon $deleted_at
 */
class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'message',
    ];

    public static array $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'message' => 'required|min:6',
    ];

}

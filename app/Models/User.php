<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon $email_verified_at
 *
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Expense> $expenses
 * @property \Illuminate\Database\Eloquent\Collection<\App\Models\Account> $accounts
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function createWithPersonalTeam(array $attributes = []): self
    {
        /** @var User $user */
        $user = self::create($attributes);
        $user->ownedTeams()->create([
            'name' => isset($attributes['name']) ? preg_replace('/^(\w+)\s?$/u', "$1's team", $attributes['name']) : 'Team',
            'personal_team' => true
        ]);

        return $user;
    }

    public function accounts(): Relation
    {
        return $this->hasMany(Account::class);
    }

    public function expenses(): Relation
    {
        return $this->hasManyThrough(Expense::class, Account::class);
    }
}

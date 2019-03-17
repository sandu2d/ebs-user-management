<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Traits\ModelHelper;

class User extends Model
{
    use ModelHelper;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activated',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * Return user`s groups
     *
     * @return mixed
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups', 'user_id', 'group_id');
    }

    /**
     * Return user`s token
     *
     * @return mixed
     */
    public function token()
    {
        return $this->hasOne(Token::class, 'user_id');
    }

    /**
     * Get user`s name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set user`s name
     *
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get user`s email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set user`s email
     *
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Check if user has permission
     *
     * @param string $code
     * @return boolean
     */
    public function hasPermission(string $code): bool
    {
        return (bool) count(Permission::where('code', "{$code}")
            ->join('group_permissions', 'group_permissions.permission_id', 'permissions.id')
            ->whereIn('group_permissions.group_id',
                $this->groups()->pluck('groups.id')->toArray()
            )->get()) && $this->isActivated();
    }

    /**
     * Check if user was blocked
     *
     * @return boolean
     */
    public function isBlocked(): bool
    {
        return (bool) $this->blocked;
    }

    /**
     * Change user`s blocked status
     *
     * @param boolean $status
     * @return User
     */
    public function setBlockedValue(bool $status): User
    {
        $this->blocked = $status;

        return $this;
    }

    /**
     * Check if user`s account was activated
     *
     * @return boolean
     */
    public function isActivated(): bool
    {
        return (bool) $this->activated;
    }

    /**
     * Change user`s activated status
     *
     * @param boolean $status
     * @return User
     */
    public function setActivatedValue(bool $status): User
    {
        $this->activated = $status;

        return $this;
    }
}
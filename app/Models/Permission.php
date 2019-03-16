<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelHelper;

class Permission extends Model
{
    use ModelHelper;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_permissions', 'permission_id', 'group_id');
    }

    /**
     * Get permision`s name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get permission`s code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
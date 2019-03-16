<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\ModelHelper;

class Token extends Model
{
    use ModelHelper;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'access_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * Return owned user
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Refresh token
     *
     * @return Token
     */
    public function refresh(): Token
    {
        $this->token = app('hash')->make($this->user->email);
        $this->updated_at = time();
        $this->expires_at = time() + 86400; // 24h

        $this->save();

        return $this;
    }

    /**
     * Return token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
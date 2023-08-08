<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OauthAccessToken extends Model
{
    use HasFactory;

    protected $connection = 'mysql_orfi_web';
    protected $table = 'oauth_access_tokens';

    /**
     * @return HasMany
     */
    public function subscription(): HasMany
    {
        return $this->hasMany(Subscription::class, 'user_id', 'user_id');
    }
}

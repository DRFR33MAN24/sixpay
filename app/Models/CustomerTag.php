<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerTag extends Model
{
    use HasFactory;

                /**
     * @return HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(User::class, 'tag_id', 'id');
    }

}

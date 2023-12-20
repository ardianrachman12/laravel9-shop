<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    /**
     * Get all of the Addresses for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}

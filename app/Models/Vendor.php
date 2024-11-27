<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $table = 'vendor';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_code', 'code');
    }
}

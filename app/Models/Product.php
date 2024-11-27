<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'product';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_code', 'code');
    }

    public function retrievalItems(): HasMany
    {
        return $this->hasMany(RetrievalItem::class, 'product_code', 'code');
    }
}

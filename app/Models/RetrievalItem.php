<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RetrievalItem extends Model
{
    protected $table = 'retrieval_item';

    public function retrieval(): BelongsTo
    {
        return $this->belongsTo(Retrieval::class, 'retrieval_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_code', 'code');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_code', 'code');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(Pic::class, 'pic_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pic extends Model
{
    protected $table = 'pic';

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_code', 'code');
    }

    public function retrievals(): HasMany
    {
        return $this->hasMany(Retrieval::class, 'pic_id', 'id');
    }

    public function retrievalItems(): HasMany
    {
        return $this->hasMany(RetrievalItem::class, 'pic_id', 'id');
    }
}

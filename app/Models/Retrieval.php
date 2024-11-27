<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Retrieval extends Model
{
    protected $table = 'retrieval';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
        static::updating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_code', 'code');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(Pic::class, 'pic_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function retrievalItems(): HasMany
    {
        return $this->hasMany(RetrievalItem::class, 'retrieval_id', 'id');
    }
}

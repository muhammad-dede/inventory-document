<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $table = 'section';

    public function pics(): HasMany
    {
        return $this->hasMany(Pic::class, 'section_code', 'code');
    }
}

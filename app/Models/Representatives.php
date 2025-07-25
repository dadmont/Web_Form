<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Representatives extends Model
{
    protected $fillable = [
        'organization_id',
        'accord',
        'name',
        'position',
        'phone',
        'snils',
        'email'  
    ];

    public function organization(): BelongsTo
        {
            return $this->belongsTo(Organization::class, 'organization_id');
        }

}

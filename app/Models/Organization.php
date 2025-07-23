<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{

    protected $table = 'Organization';

    protected $fillable = [
        'full_name',
        'short_name',
        'locality',
        'municipal_district',
        'region',
        'inn',
        'ogrn',
        'email',
        'phone',
     ];
        
    public function representatives(): HasMany
        {
            return $this->hasMany(Representatives::class);
        }
    
}

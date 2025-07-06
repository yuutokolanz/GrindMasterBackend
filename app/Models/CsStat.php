<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CsStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'map_played',
        'kills',
        'deaths',
        'hs_percent',
        'mvps'
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}

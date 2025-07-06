<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LolStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'champion_played',
        'champion_played_icon',
        'kills',
        'deaths',
        'assists',
        'cs'
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}

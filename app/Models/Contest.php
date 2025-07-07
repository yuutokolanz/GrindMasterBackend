<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'contest_date',
        'result',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function lolStat(): HasOne
    {
        return $this->hasOne(LolStat::class);
    }

    public function csStat(): HasOne
    {
        return $this->hasOne(CsStat::class);
    }
}

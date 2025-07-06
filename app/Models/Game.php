<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon_url'
    ];

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function contests(): HasMany
    {
        return $this->hasMany(Contest::class);
    }
}

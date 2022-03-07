<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillUser extends Pivot
{
    use HasFactory;

    protected $table = 'skill_user';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skill(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function recommendations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Recommendation::class, 'skill_user_id');
    }
}

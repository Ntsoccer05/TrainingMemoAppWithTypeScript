<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordState extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','recorded_at'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recordContents():HasMany
    {
        return $this->hasMany(RecordContent::class);
    }
}

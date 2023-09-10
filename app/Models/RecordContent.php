<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordContent extends Model
{
    use HasFactory;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(category::class);
    }

    public function menu():BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function date():BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordContent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'menu_id', 'category_id', 'record_state_id', 'weight','right_weight','left_weight', 'set', 'rep', 'memo'];

    // 初期データ入力時にupdated_atカラムへのデータ挿入させなくする
    const UPDATED_AT = NULL;

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

    public function recordState():BelongsTo
    {
        return $this->belongsTo(RecordState::class);
    }
}

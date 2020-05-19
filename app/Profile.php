<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        // 'origin_lat',
        // 'origin_lng',
        // 'cohabitant',
        // 'contact_weekday',
    ];

    // リレーション（１対１）
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

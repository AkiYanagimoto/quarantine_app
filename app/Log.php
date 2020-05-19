<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'distance', 'date_time', 'stay_at_home'
    ];

    protected $dates = [
        'date_time',
    ];

    // リレーション（１対多）
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

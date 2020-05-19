<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarentine extends Model
{
    protected $fillable = [
        'date', 'total_contact', 'quarentine',
    ];

    protected $dates = [
        'date',
    ];

    // リレーション（１対多）
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // リレーション（１対多）
    public function logs()
    {
        return $this->hasMany('App\Log');
    }
}

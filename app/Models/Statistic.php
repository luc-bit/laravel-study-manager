<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'statistics'; // tên bảng trong database

    protected $fillable = [
        'user_id',
        'period_type',
        'period_value',
        'year',
        'done_count',
        'pending_count',
    ];

    protected $casts = [
        'year' => 'integer',
        'done_count' => 'integer',
        'pending_count' => 'integer',
    ];

    // Quan hệ: mỗi thống kê thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

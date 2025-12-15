<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Quan hệ: mỗi task thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: trả về tên trạng thái đẹp
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'prepare' => 'Chuẩn bị',
            'doing'   => 'Đang thực hiện',
            'done'    => 'Hoàn thành',
            default   => 'Không rõ',
        };
    }
}

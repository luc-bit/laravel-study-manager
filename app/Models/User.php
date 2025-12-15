<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    // Các cột cần ẩn khi trả về JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kiểu dữ liệu cho các cột
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function grades()
{
    return $this->hasMany(Grade::class);
}

}

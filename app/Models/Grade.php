<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_name',
        'process_score',
        'midterm_score',
        'final_score',
        'process_weight',
        'midterm_weight',
        'final_weight',
        'result_score',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

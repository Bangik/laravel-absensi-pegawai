<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'status',
        'note',
        'dates',
        'start',
        'end',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

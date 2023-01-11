<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'note',
        'dates_start',
        'dates_end',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

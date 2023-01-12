<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
        'target',
        'report',
        'status',
        'approval',
        'note',
        'dates',
        'due_date',
        'start',
        'end',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

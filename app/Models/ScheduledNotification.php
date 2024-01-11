<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledNotification extends Model
{
    protected $fillable = [
        'scheduled_at',
        'message',
        'contact_id',
        'user_id',
        'is_read',
        'created_at',
        'updated_at',
        
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSystemNotification extends Model
{
    use HasFactory;

    protected $table = 'customer_system_notifications';
    protected $fillable = ['customer_id', 'system_notification_id'];

    public function systemNotification()
    {
        return $this->belongsTo(SystemNotification::class, 'system_notification_id');
    }
}

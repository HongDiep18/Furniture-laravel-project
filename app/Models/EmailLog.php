<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $table = 'email_logs';

    protected $fillable = [
        'recipient_email',
        'user_id',
        'subscriber_id',
        'template_id',
        'subject',
        'content',
        'status',
        'error_message'
    ];
}

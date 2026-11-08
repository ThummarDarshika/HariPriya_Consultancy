<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const NOTIFICATION_EMAIL = 'notification_email';

    protected $fillable = ['key', 'value'];

    public static function notificationEmail(): ?string
    {
        return self::query()->where('key', self::NOTIFICATION_EMAIL)->value('value')
            ?: config('mail.contact_inquiry.to');
    }
}

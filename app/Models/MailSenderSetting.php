<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSenderSetting extends Model
{
    protected $fillable = ['email', 'name', 'smtp_host', 'smtp_port', 'smtp_scheme', 'smtp_username', 'smtp_password'];

    protected $hidden = ['smtp_password'];

    protected function casts(): array
    {
        return [
            'smtp_port' => 'integer',
            'smtp_password' => 'encrypted',
        ];
    }
}

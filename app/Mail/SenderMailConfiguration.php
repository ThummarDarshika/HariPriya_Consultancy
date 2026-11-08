<?php

namespace App\Mail;

use App\Models\MailSenderSetting;

class SenderMailConfiguration
{
    public function applySaved(): bool
    {
        $settings = MailSenderSetting::query()->first();

        if (! $settings) {
            return false;
        }

        $this->apply(
            $settings->email,
            $settings->name,
            $settings->smtp_host,
            $settings->smtp_port,
            $settings->smtp_scheme,
            $settings->smtp_username,
            $settings->smtp_password,
        );

        return true;
    }

    public function apply(string $email, string $name, string $host, int $port, string $scheme, string $username, string $password): void
    {
        config()->set([
            'mail.default' => 'configured_sender',
            'mail.from.address' => $email,
            'mail.from.name' => $name,
            'mail.mailers.configured_sender' => [
                'transport' => 'smtp',
                'scheme' => $scheme,
                'host' => $host,
                'port' => $port,
                'username' => $username,
                'password' => $password,
                'timeout' => 10,
            ],
        ]);
    }
}

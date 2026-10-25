<?php

return [
    'admin' => [
        'name' => env('CMS_ADMIN_NAME', 'Administrator'),
        'email' => env('CMS_ADMIN_EMAIL'),
        'password' => env('CMS_ADMIN_PASSWORD'),
    ],
    'founder' => [
        'image' => '/assets/a-quote-CBJAnhu7.webp',
        'name' => 'Michael R. Bennett',
        'role' => 'Founder & CEO',
    ],
    'collections' => [
        'products' => 'Products',
        'services' => 'Services',
        'blogs' => 'Blogs',
        'testimonials' => "Client's review",
        'case-studies' => 'Case Studies',
        'faqs' => 'FAQs',
        'team-members' => 'Team Members',
    ],
    'managed_assets' => [
        'brochure' => ['page' => 'global', 'label' => 'Download Brochure PDF', 'kind' => 'document', 'default' => null],
        'site.logo' => ['page' => 'global', 'label' => 'Site logo', 'kind' => 'image', 'default' => null],
        'site.favicon' => ['page' => 'global', 'label' => 'Favicon', 'kind' => 'image', 'default' => '/favicon.ico'],
        'cta.background' => ['page' => 'global', 'label' => 'Shared CTA background (Home, Products & Services)', 'kind' => 'image', 'default' => '/assets/cta-bg-CKwZ5V_V.png'],
        'home.solutions_background' => ['page' => 'home', 'label' => 'Manufacturing solutions background', 'kind' => 'image', 'default' => '/assets/why-choose-DNef7VyW.png'],
        'about.team_avatar_1' => ['page' => 'about', 'label' => 'Team highlight image 1', 'kind' => 'image', 'default' => '/assets/team-avatar-01.webp'],
        'about.team_avatar_2' => ['page' => 'about', 'label' => 'Team highlight image 2', 'kind' => 'image', 'default' => '/assets/avatar-3-C3tMRDPM.png'],
        'about.team_avatar_3' => ['page' => 'about', 'label' => 'Team highlight image 3', 'kind' => 'image', 'default' => '/assets/avatar-4-UUYBlZFU.png'],
        'about.team_avatar_4' => ['page' => 'about', 'label' => 'Team highlight image 4', 'kind' => 'image', 'default' => '/assets/avatar-1-BctzwD-q.png'],
        'about.since_label' => ['page' => 'about', 'label' => 'Since marquee text', 'kind' => 'text', 'default' => 'Since - 2005'],
    ],
];

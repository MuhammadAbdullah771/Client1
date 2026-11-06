<?php

namespace Database\Seeders;

use App\Models\ItManagerProfile;
use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ItServicesPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $itService = Service::where('title', 'IT Services')->first();
        if (!$itService) {
            return;
        }

        if (!ItManagerProfile::first()) {
            ItManagerProfile::create([
                'name' => 'IT Manager',
                'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop',
                'vision' => 'To deliver cutting-edge software solutions that empower businesses through Full Stack Web Applications, Flutter Mobile Apps, and Desktop Applications. We believe in clean code, agile delivery, and putting the user experience first.',
                'linkedin_url' => 'https://linkedin.com/in/abdullah',
                'email' => 'teamabdullahnd@gmail.com',
                'whatsapp' => '923206418200',
                'order' => 0,
            ]);
        }

        $items = [
            [
                'title' => 'Full Stack Web Applications (Laravel)',
                'description' => 'Scalable, secure web applications built with Laravel. From APIs to full-stack SPAs, we deliver modern web solutions that grow with your business.',
                'icon' => 'code',
                'order' => 1,
            ],
            [
                'title' => 'Flutter Mobile Apps',
                'description' => 'Cross-platform iOS and Android applications with Flutter. Beautiful UI, native performance, and a single codebase for faster delivery.',
                'icon' => 'phone_android',
                'order' => 2,
            ],
            [
                'title' => 'Desktop Applications in C#',
                'description' => 'Robust Windows desktop applications using C# and .NET. Enterprise-grade software for internal tools, dashboards, and workflows.',
                'icon' => 'desktop_windows',
                'order' => 3,
            ],
        ];

        foreach ($items as $item) {
            PortfolioItem::updateOrCreate(
                [
                    'service_id' => $itService->id,
                    'title' => $item['title'],
                ],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        // Privacy Policy
        Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'content' => 'Privacy Policy Content

This Privacy Policy describes how 9Associates ("we", "our", or "us") collects, uses, and protects your personal information when you use our website and services.

Information We Collect
We may collect personal information such as:
- Name and contact information
- Email address
- Phone number
- Company information
- Any other information you provide to us

How We Use Your Information
We use the information we collect to:
- Provide and improve our services
- Respond to your inquiries
- Send you updates and communications
- Comply with legal obligations

Data Security
We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.

Contact Us
If you have any questions about this Privacy Policy, please contact us through our contact page.',
                'is_active' => true,
            ]
        );

        // Terms of Service
        Page::updateOrCreate(
            ['slug' => 'terms-of-service'],
            [
                'title' => 'Terms of Service',
                'content' => 'Terms of Service

Please read these Terms of Service ("Terms") carefully before using the 9Associates website and services.

Acceptance of Terms
By accessing or using our website, you agree to be bound by these Terms. If you do not agree to these Terms, please do not use our services.

Use of Services
You agree to use our services only for lawful purposes and in accordance with these Terms. You agree not to:
- Violate any applicable laws or regulations
- Infringe upon the rights of others
- Transmit any harmful or malicious code
- Attempt to gain unauthorized access to our systems

Intellectual Property
All content on this website, including text, graphics, logos, and software, is the property of 9Associates and is protected by copyright and other intellectual property laws.

Limitation of Liability
9Associates shall not be liable for any indirect, incidental, special, or consequential damages arising out of or in connection with your use of our services.

Changes to Terms
We reserve the right to modify these Terms at any time. Your continued use of our services after any changes constitutes acceptance of the new Terms.

Contact Information
For questions about these Terms, please contact us through our contact page.',
                'is_active' => true,
            ]
        );

        $this->command->info('Pages seeded successfully!');
    }
}


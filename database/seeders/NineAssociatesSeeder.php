<?php

namespace Database\Seeders;

use App\Models\Insight;
use App\Models\Job;
use App\Models\Leader;
use App\Models\Milestone;
use App\Models\Service;
use App\Models\SubService;
use Illuminate\Database\Seeder;

class NineAssociatesSeeder extends Seeder
{
    public function run(): void
    {
        // Deactivate all existing services first
        Service::query()->update(['is_active' => false]);

        // Create the 5 exact services as specified
        Service::updateOrCreate(
            ['title' => 'Accounting'],
            [
                'description' => 'Efficient accounting services are essential for the growth of any business. Record daily transactions in suitable accounting system as recommended by management, prepare monthly reporting pack for management review. Prepare and submit regulatory filings e.g. VAT return and withholding tax returns.',
                'icon' => 'account_balance',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Tax'],
            [
                'description' => 'Expert tax planning and compliance services to help you navigate complex tax regulations and optimize your tax strategy. We provide comprehensive tax advisory, preparation, and filing services.',
                'icon' => 'receipt',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Policies and procedures'],
            [
                'description' => 'We provide range of services for policies and procedures ranging from preparing gap analysis, identifying the gaps in existing policies, providing recommendations to improve existing policies and preparing policies and procedures for different departments.',
                'icon' => 'description',
                'order' => 3,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Financial administration'],
            [
                'description' => 'Comprehensive financial administration services including financial reporting, budgeting, cash flow management, and financial analysis to support your business operations and strategic decision-making.',
                'icon' => 'assessment',
                'order' => 4,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Tax Advisory'],
            [
                'description' => 'Expert tax advisory services to help your business navigate changing tax laws and optimize strategic planning.',
                'icon' => 'account_balance_wallet',
                'order' => 5,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'VAT & Corporate Tax'],
            [
                'description' => 'Complete VAT and Corporate Tax compliance and consulting services for GCC and international markets.',
                'icon' => 'percent',
                'order' => 6,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Payroll Management'],
            [
                'description' => 'End-to-end payroll processing and HR compliance services tailored to your organizational structure.',
                'icon' => 'payments',
                'order' => 7,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Business Setup'],
            [
                'description' => 'Professional company formation and business setup services to launch your enterprise in new jurisdictions seamlessly.',
                'icon' => 'domain_add',
                'order' => 8,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['title' => 'Audit & Assurance'],
            [
                'description' => 'Independent audit and assurance services providing credibility and transparency to your financial statements.',
                'icon' => 'fact_check',
                'order' => 9,
                'is_active' => true,
            ]
        );

        $itSupportService = Service::updateOrCreate(
            ['title' => 'IT Support'],
            [
                'description' => 'Comprehensive IT services including web development, system integration, and technology consulting to support your business digital transformation.',
                'icon' => 'computer',
                'order' => 5,
                'is_active' => true,
            ]
        );

        // Get services for sub-services
        $accountingService = Service::where('title', 'Accounting')->first();
        $taxService = Service::where('title', 'Tax')->first();
        $policiesService = Service::where('title', 'Policies and procedures')->first();
        $financialAdminService = Service::where('title', 'Financial administration')->first();

        // Sub-Services for Accounting
        if ($accountingService) {
            SubService::updateOrCreate(
                ['service_id' => $accountingService->id, 'title' => 'Bookkeeping'],
                [
                    'description' => 'Record daily transactions in suitable accounting system as recommended by management, prepare monthly reporting pack for management review.',
                    'order' => 1,
                    'is_active' => true,
                    'heading_1' => 'Daily Transaction Recording',
                    'content_1' => 'We maintain accurate records of all your daily business transactions, ensuring compliance with accounting standards and providing you with real-time financial visibility.',
                    'heading_2' => 'Monthly Reporting',
                    'content_2' => 'Our team prepares comprehensive monthly reporting packs for management review, including profit and loss statements, balance sheets, and cash flow reports.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $accountingService->id, 'title' => 'Regulatory Filing'],
                [
                    'description' => 'Prepare and submit regulatory filings including VAT returns, withholding tax returns, and other compliance documents.',
                    'order' => 2,
                    'is_active' => true,
                    'heading_1' => 'VAT Return Preparation',
                    'content_1' => 'We handle all VAT return preparation and submission, ensuring accuracy and compliance with local tax regulations.',
                    'heading_2' => 'Withholding Tax Returns',
                    'content_2' => 'Our experts prepare and file withholding tax returns, helping you meet all regulatory requirements on time.',
                ]
            );
        }

        // Sub-Services for Tax
        if ($taxService) {
            SubService::updateOrCreate(
                ['service_id' => $taxService->id, 'title' => 'Tax Planning'],
                [
                    'description' => 'Strategic tax planning to optimize your tax position and minimize liabilities while ensuring full compliance.',
                    'order' => 1,
                    'is_active' => true,
                    'heading_1' => 'Strategic Tax Optimization',
                    'content_1' => 'We develop comprehensive tax strategies tailored to your business needs, helping you minimize tax liabilities while maintaining full compliance.',
                    'heading_2' => 'Compliance Assurance',
                    'content_2' => 'Our team ensures all tax planning strategies are fully compliant with current tax laws and regulations.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $taxService->id, 'title' => 'Tax Preparation & Filing'],
                [
                    'description' => 'Professional tax return preparation and filing services for individuals and businesses.',
                    'order' => 2,
                    'is_active' => true,
                    'heading_1' => 'Individual Tax Returns',
                    'content_1' => 'We prepare and file individual tax returns, ensuring all deductions and credits are properly claimed.',
                    'heading_2' => 'Corporate Tax Returns',
                    'content_2' => 'Our experts handle corporate tax return preparation, ensuring accuracy and timely submission.',
                ]
            );
        }

        // Sub-Services for Policies and Procedures
        if ($policiesService) {
            SubService::updateOrCreate(
                ['service_id' => $policiesService->id, 'title' => 'Policy Development'],
                [
                    'description' => 'Development of comprehensive policies and procedures tailored to your organization\'s needs and industry requirements.',
                    'order' => 1,
                    'is_active' => true,
                    'heading_1' => 'Gap Analysis',
                    'content_1' => 'We conduct thorough gap analysis to identify areas where policies need to be developed or updated.',
                    'heading_2' => 'Custom Policy Creation',
                    'content_2' => 'Our team creates custom policies and procedures that align with your business objectives and regulatory requirements.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $policiesService->id, 'title' => 'Policy Review & Improvement'],
                [
                    'description' => 'Review existing policies and provide recommendations for improvement to enhance efficiency and compliance.',
                    'order' => 2,
                    'is_active' => true,
                    'heading_1' => 'Existing Policy Review',
                    'content_1' => 'We review your existing policies to identify gaps, redundancies, and areas for improvement.',
                    'heading_2' => 'Implementation Support',
                    'content_2' => 'We provide guidance and support for implementing improved policies across your organization.',
                ]
            );
        }

        // Sub-Services for Financial Administration
        if ($financialAdminService) {
            SubService::updateOrCreate(
                ['service_id' => $financialAdminService->id, 'title' => 'Financial Reporting'],
                [
                    'description' => 'Comprehensive financial reporting services including monthly, quarterly, and annual financial statements.',
                    'order' => 1,
                    'is_active' => true,
                    'heading_1' => 'Monthly Financial Reports',
                    'content_1' => 'We prepare detailed monthly financial reports to help you track performance and make informed decisions.',
                    'heading_2' => 'Annual Financial Statements',
                    'content_2' => 'Our team prepares comprehensive annual financial statements in compliance with accounting standards.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $financialAdminService->id, 'title' => 'Budgeting & Cash Flow Management'],
                [
                    'description' => 'Strategic budgeting and cash flow management to ensure financial stability and growth.',
                    'order' => 2,
                    'is_active' => true,
                    'heading_1' => 'Budget Development',
                    'content_1' => 'We help develop realistic budgets that align with your business goals and financial capabilities.',
                    'heading_2' => 'Cash Flow Forecasting',
                    'content_2' => 'Our cash flow management services help you anticipate and plan for future financial needs.',
                ]
            );
        }

        // Sub-Services for IT Support
        if ($itSupportService) {
            SubService::updateOrCreate(
                ['service_id' => $itSupportService->id, 'title' => 'Flutter Mobile Apps'],
                [
                    'description' => 'Build cross-platform mobile applications with Flutter for iOS and Android. High-performance, beautiful UI, and native-like experience.',
                    'order' => 1,
                    'is_active' => true,
                    'heading_1' => 'Cross-Platform Development',
                    'content_1' => 'We develop mobile applications using Flutter that work seamlessly on both iOS and Android platforms, reducing development time and costs while maintaining native performance.',
                    'heading_2' => 'Modern UI/UX Design',
                    'content_2' => 'Our Flutter apps feature beautiful, responsive user interfaces that provide an excellent user experience across all devices and screen sizes.',
                    'heading_3' => 'Fast Development & Hot Reload',
                    'content_3' => 'Leverage Flutter\'s hot reload feature for rapid development cycles, allowing you to see changes instantly and iterate quickly.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $itSupportService->id, 'title' => 'Cybersecurity Consultation'],
                [
                    'description' => 'Comprehensive cybersecurity consultation services to protect your business from threats and ensure data security compliance.',
                    'order' => 2,
                    'is_active' => true,
                    'heading_1' => 'Security Assessment',
                    'content_1' => 'We conduct thorough security assessments to identify vulnerabilities in your systems and infrastructure, providing detailed reports and recommendations.',
                    'heading_2' => 'Threat Protection',
                    'content_2' => 'Our cybersecurity experts help implement robust protection measures against malware, phishing, ransomware, and other cyber threats.',
                    'heading_3' => 'Compliance & Best Practices',
                    'content_3' => 'We ensure your systems comply with industry standards and regulations, implementing security best practices to protect sensitive data.',
                ]
            );

            SubService::updateOrCreate(
                ['service_id' => $itSupportService->id, 'title' => 'Desktop Applications In C Sharp and Flutter'],
                [
                    'description' => 'Develop robust desktop applications using C# and .NET framework, or modern cross-platform desktop apps with Flutter for Windows, macOS, and Linux.',
                    'order' => 3,
                    'is_active' => true,
                    'heading_1' => 'C# Desktop Applications',
                    'content_1' => 'We develop enterprise-grade Windows desktop applications using C# and .NET framework, featuring modern UI with WPF or WinForms for optimal performance and user experience.',
                    'heading_2' => 'Flutter Desktop Applications',
                    'content_2' => 'Build cross-platform desktop applications with Flutter that run on Windows, macOS, and Linux from a single codebase, ensuring consistent functionality across all platforms.',
                    'heading_3' => 'Enterprise Solutions',
                    'content_3' => 'Our desktop applications are designed for enterprise use, with features like data management, reporting, integration capabilities, and scalable architecture.',
                ]
            );
        }

        // Leaders (without image URLs - images must be uploaded via admin)
        Leader::updateOrCreate(
            ['email' => 'jonathan@9associates.com'],
            [
                'name' => 'Jonathan Walcott',
                'role' => 'CHIEF EXECUTIVE OFFICER',
                'department' => 'Finance',
                'bio' => 'With over 20 years in investment banking, Jonathan founded 9Associates to bridge the gap between financial strategy and operational reality.',
                'linkedin' => 'https://linkedin.com/in/jonathan-walcott',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Leader::updateOrCreate(
            ['email' => 'sarah@9associates.com'],
            [
                'name' => 'Sarah Jenkins',
                'role' => 'HEAD OF STRATEGY',
                'department' => 'Strategy',
                'bio' => 'Sarah specializes in international market entry and has led our expansion efforts across Europe and the Middle East with 10 Years Experience.',
                'linkedin' => 'https://linkedin.com/in/sarah-jenkins',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Leader::updateOrCreate(
            ['email' => 'michael@9associates.com'],
            [
                'name' => 'Michael Chen',
                'role' => 'CHIEF FINANCIAL OFFICER',
                'department' => 'Finance',
                'bio' => 'Michael oversees all fiscal activities and provides our clients with expert guidance on risk management and tax optimization strategies.',
                'linkedin' => 'https://linkedin.com/in/michael-chen',
                'order' => 3,
                'is_active' => true,
            ]
        );

        // Milestones
        Milestone::updateOrCreate(
            ['year' => 2010, 'title' => 'The Beginning'],
            [
                'description' => 'Founded in London with a team of three visionaries aiming to disrupt traditional consulting.',
                'position' => 'left',
                'order' => 1,
            ]
        );

        Milestone::updateOrCreate(
            ['year' => 2015, 'title' => 'Global Footprint'],
            [
                'description' => 'Successfully established our headquarters in New York City, marking our first international expansion.',
                'position' => 'right',
                'order' => 2,
            ]
        );

        Milestone::updateOrCreate(
            ['year' => 2018, 'title' => '500+ Corporate Clients'],
            [
                'description' => 'Reached a major milestone of serving over 500 diverse corporate entities across five continents.',
                'position' => 'left',
                'order' => 3,
            ]
        );

        Milestone::updateOrCreate(
            ['year' => 2023, 'title' => 'Digital Transformation'],
            [
                'description' => 'Launched our comprehensive Digital Transformation suite, integrating AI and data analytics into our core services.',
                'position' => 'right',
                'order' => 4,
            ]
        );

        // Jobs
        Job::updateOrCreate(
            ['title' => 'Senior Audit Associate'],
            [
                'department' => 'AUDIT',
                'location' => 'London, UK',
                'employment_type' => 'Full-time',
                'description' => 'We are seeking a Senior Audit Associate to join our team.',
                'is_active' => true,
            ]
        );

        Job::updateOrCreate(
            ['title' => 'Business Strategy Consultant'],
            [
                'department' => 'ADVISORY',
                'location' => 'New York, USA',
                'employment_type' => 'Full-time',
                'description' => 'Join our advisory team as a Business Strategy Consultant.',
                'is_active' => true,
            ]
        );

        Job::updateOrCreate(
            ['title' => 'International Tax Manager'],
            [
                'department' => 'TAX',
                'location' => 'Singapore',
                'employment_type' => 'Full-time',
                'description' => 'We are looking for an International Tax Manager.',
                'is_active' => true,
            ]
        );

        // Insights
        Insight::updateOrCreate(
            ['title' => 'Navigating Global Tax Reforms in 2024'],
            [
                'excerpt' => 'Our experts analyze the shifting landscape of international taxation and what it means for your business strategy in the coming year.',
                'category' => 'Taxation',
                'published_at' => now(),
                'is_featured' => true,
            ]
        );

        Insight::updateOrCreate(
            ['title' => 'Understanding VAT & Corporate Tax Updates'],
            [
                'excerpt' => 'A comprehensive guide to the latest VAT and Corporate Tax regulations affecting businesses in the GCC.',
                'category' => 'Tax',
                'published_at' => now(),
                'is_featured' => false,
            ]
        );

        Insight::updateOrCreate(
            ['title' => 'Best Practices for Payroll Management'],
            [
                'excerpt' => 'Discover how modern payroll systems can ensure HR compliance and reduce administrative overhead.',
                'category' => 'HR',
                'published_at' => now()->subDays(2),
                'is_featured' => false,
            ]
        );

        Insight::updateOrCreate(
            ['title' => 'Guide to Business Setup in New Markets'],
            [
                'excerpt' => 'Key considerations and legal frameworks to understand before establishing your company in a new jurisdiction.',
                'category' => 'Business',
                'published_at' => now()->subDays(5),
                'is_featured' => true,
            ]
        );

        Insight::updateOrCreate(
            ['title' => 'The Importance of Audit & Assurance'],
            [
                'excerpt' => 'Why transparent financial reporting is critical for stakeholder trust and long-term enterprise growth.',
                'category' => 'Audit',
                'published_at' => now()->subDays(10),
                'is_featured' => false,
            ]
        );

        $this->command->info('9Associates seeder completed!');
        $this->command->warn('Note: Images must be uploaded manually via the admin panel. The seeder does not include image URLs.');
    }
}


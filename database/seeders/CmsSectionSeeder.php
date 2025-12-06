<?php

namespace Database\Seeders;

use App\Models\CmsSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update the main services section
        CmsSection::updateOrCreate(
            ['section_key' => 'main_services'],
            [
                'section_name' => 'Main Services Section',
                'title' => "Our \nMain Services",
                'subtitle' => null,
                'content' => "H&Co Properties provides expert real estate services in Dubai, helping you buy, sell, or invest with ease. From luxury homes to commercial spaces, we guide you every step of the way.",
                'list_items' => [
                    'Properties Sales and Listing',
                    'Real Estate Investment and Consulting',
                    'Property Management'
                ],
                'is_active' => true,
            ]
        );

        // Create or update the counting/statistics section
        CmsSection::updateOrCreate(
            ['section_key' => 'counting_section'],
            [
                'section_name' => 'Counting/Statistics Section',
                'title' => null,
                'subtitle' => null,
                'content' => null,
                'list_items' => null,
                'stats_items' => [
                    [
                        'value' => '$15.4M',
                        'description' => "Owned from \nProperties Transactions"
                    ],
                    [
                        'value' => '25K+',
                        'description' => "Owned from \nProperties Transactions"
                    ],
                    [
                        'value' => '500',
                        'description' => "Owned from \nProperties Transactions"
                    ]
                ],
                'is_active' => true,
            ]
        );

        // Create or update the testimonials section
        CmsSection::updateOrCreate(
            ['section_key' => 'testimonials_section'],
            [
                'section_name' => 'Testimonials Section',
                'title' => 'What Client Says About Us',
                'subtitle' => 'Testimonial',
                'content' => null,
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => [
                    [
                        'quote' => 'Posuere mus curabitur parturient scelerisque ...',
                        'author' => 'Mark Wiggins',
                        'position' => 'CEO ( Grodins Group )'
                    ]
                ],
                'is_active' => true,
            ]
        );

        // Create or update About page sections
        // About Page Banner
        CmsSection::updateOrCreate(
            ['section_key' => 'about_page_banner'],
            [
                'section_name' => 'About Page Banner',
                'title' => 'Who We Are',
                'subtitle' => 'Discover H C O Real Estate: Our Mission and Vision',
                'content' => null,
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => null,
                'is_active' => true,
            ]
        );

        // About Hero Banner
        CmsSection::updateOrCreate(
            ['section_key' => 'about_hero_banner'],
            [
                'section_name' => 'About Hero Banner',
                'title' => 'Welcome to H C O Real Estate, where we believe in empowering individuals and families through exceptional real estate services.',
                'subtitle' => 'Empowering Your Real Estate Journey',
                'content' => "At H C O Real Estate, we are more than just a real estate agency—we are a team driven by a mission to empower individuals and families to achieve their dreams of finding the perfect home. With a focus on integrity, transparency, and a client-first approach, we are dedicated to making the process of buying, selling, and leasing as smooth and fulfilling as possible. Our clients are at the core of everything we do, and we strive to turn real estate transactions into meaningful experiences that enhance lives.",
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => null,
                'is_active' => true,
            ]
        );

        // About Partners
        CmsSection::updateOrCreate(
            ['section_key' => 'about_partners'],
            [
                'section_name' => 'About Partners Section',
                'title' => 'Trusted Allies',
                'subtitle' => 'Our Partners',
                'content' => null,
                'list_items' => [
                    'assets/images/partner/oh_logo_01-min.png',
                    'assets/images/partner/oh_logo_02-min.png',
                    'assets/images/partner/oh_logo_03-min.png',
                    'assets/images/partner/oh_logo_04-min.png',
                ],
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => null,
                'is_active' => true,
            ]
        );

        // Mission & Vision Section
        CmsSection::updateOrCreate(
            ['section_key' => 'mission_vision_section'],
            [
                'section_name' => 'Mission & Vision Section',
                'title' => 'Our Mission & Vision: Guiding Every Step of Your Journey',
                'subtitle' => null,
                'content' => null,
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => [
                    [
                        'title' => 'Our Mission',
                        'content' => 'At H C O Real Estate, our mission is to empower individuals and families by providing exceptional real estate services with integrity, transparency, and a client-first approach. We strive to simplify the buying, selling, and leasing process, ensuring our clients find not just properties, but homes that inspire and enrich their lives.',
                        'is_active' => true,
                    ],
                    [
                        'title' => 'Our Vision',
                        'content' => 'Our vision is to be a trusted leader in the real estate industry, recognized for our commitment to excellence and innovation. We aim to create lasting relationships with our clients and communities, transforming the real estate experience through personalized service and cutting-edge technology. Ultimately, we envision a future where everyone can find their perfect space to thrive.',
                        'is_active' => false,
                    ],
                ],
                'is_active' => true,
            ]
        );

        // Contact Info Section
        CmsSection::updateOrCreate(
            ['section_key' => 'contact_info_section'],
            [
                'section_name' => 'Contact Info Section',
                'title' => 'Contact',
                'subtitle' => null,
                'content' => null,
                'contact_phones' => [
                    ['title' => 'Sales', 'number' => '+971 52 778 5359'],
                    ['title' => 'Support', 'number' => '+971 52 778 5369'],
                ],
                'contact_addresses' => [
                    ['title' => 'Office Address', 'content' => 'H&Co properties full address.'],
                ],
                'contact_emails' => [
                    'info@handcoproperties.com'
                ],
                'is_active' => true,
            ]
        );

        // Social Links Section
        CmsSection::updateOrCreate(
            ['section_key' => 'social_links_section'],
            [
                'section_name' => 'Social Links Section',
                'title' => 'Follow Us',
                'social_links' => [
                    ['platform' => 'Facebook', 'url' => '#', 'icon_class' => 'fab fa-facebook-f'],
                    ['platform' => 'Twitter', 'url' => '#', 'icon_class' => 'fab fa-twitter'],
                    ['platform' => 'LinkedIn', 'url' => '#', 'icon_class' => 'fab fa-linkedin-in'],
                    ['platform' => 'Google Plus', 'url' => '#', 'icon_class' => 'fab fa-google-plus-g'],
                    ['platform' => 'Pinterest', 'url' => '#', 'icon_class' => 'fab fa-pinterest-p'],
                ],
                'is_active' => true,
            ]
        );

        // Delete old Privacy & Policy sections (if they exist)
        CmsSection::whereIn('section_key', ['privacy_page_banner', 'privacy_hero_banner', 'privacy_content_section'])->delete();

        // Privacy & Policy Section
        CmsSection::updateOrCreate(
            ['section_key' => 'privacy_policy_section'],
            [
                'section_name' => 'Privacy & Policy Section',
                'title' => 'Privacy & Policy',
                'subtitle' => 'Your Privacy Matters to Us',
                'content' => '<h3>Information We Collect</h3><p>We collect information that you provide directly to us, including your name, email address, phone number, and any other information you choose to provide when using our services.</p><h3>How We Use Your Information</h3><p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you about our services.</p><h3>Data Security</h3><p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p><h3>Contact Us</h3><p>If you have any questions about this Privacy Policy, please contact us at info@handcoproperties.com</p>',
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => null,
                'is_active' => true,
            ]
        );

        // FAQ Section
        CmsSection::updateOrCreate(
            ['section_key' => 'faq_section'],
            [
                'section_name' => 'FAQ Section',
                'title' => 'Frequently Asked Questions',
                'subtitle' => null,
                'content' => null,
                'list_items' => null,
                'stats_items' => null,
                'testimonials' => null,
                'accordion_items' => [
                    [
                        'title' => 'What is included in Dacha\'s property management services?',
                        'content' => 'Our property management services include tenant screening, rent collection, property maintenance, regular inspections, and handling tenant relations. We ensure your property is well-maintained and profitable.',
                        'is_active' => false,
                    ],
                    [
                        'title' => 'How can Dacha help me invest in Dubai\'s off-plan properties?',
                        'content' => 'We provide comprehensive guidance on off-plan investments, including market analysis, developer verification, payment plan assistance, and legal documentation support to ensure a secure investment.',
                        'is_active' => false,
                    ],
                ],
                'is_active' => true,
            ]
        );
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CmsSection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share footer CTA with footer partial
        View::composer('website.partials._footer', function ($view) {
            $footerRegisterCta = CmsSection::getByKey('footer_register_cta');
            $view->with('footerRegisterCta', $footerRegisterCta);
        });

        // Share contact info with footer and contact page
        View::composer(['website.partials._footer', 'website.contact'], function ($view) {
            $contactInfoSection = CmsSection::getByKey('contact_info_section');
            $view->with('contactInfoSection', $contactInfoSection);
        });

        // Share social links to footer
        View::composer('website.partials._footer', function ($view) {
            $socialLinksSection = CmsSection::getByKey('social_links_section');
            $view->with('socialLinksSection', $socialLinksSection);
        });
    }
}

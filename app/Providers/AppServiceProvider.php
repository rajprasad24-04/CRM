<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\FinancialData;
use App\Models\Notice;
use App\Models\NoticeComment;
use App\Models\NoticeLike;
use App\Models\Password;
use App\Models\User;
use App\Observers\AuditableObserver;
use Illuminate\Support\ServiceProvider;

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
        Client::observe(AuditableObserver::class);
        FinancialData::observe(AuditableObserver::class);
        Password::observe(AuditableObserver::class);
        Notice::observe(AuditableObserver::class);
        NoticeComment::observe(AuditableObserver::class);
        NoticeLike::observe(AuditableObserver::class);
        User::observe(AuditableObserver::class);
    }
}

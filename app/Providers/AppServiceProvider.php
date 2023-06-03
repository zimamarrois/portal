<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Facades\Health;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use Illuminate\Validation\Rules\Password;
use JeffGreco13\FilamentBreezy\FilamentBreezy as FilamentBreezyFilamentBreezy;

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
        Health::checks([

            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(40)
                ->failWhenLoadIsHigherInTheLast15Minutes(30),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            // OptimizedAppCheck::new()
            //     ->checkConfig()
            //     ->checkRoutes(),
            CacheCheck::new(),
            DatabaseTableSizeCheck::new()
                ->table('data_pmis', maxSizeInMb: 1_000)
                ->table('pendaftarans', maxSizeInMb: 2_000),
            DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            PingCheck::new()->url('https://google.com'),
            SecurityAdvisoriesCheck::new(),
        ]);
        // FilamentClearCache::addCommand('page-cache:clear');
        FilamentBreezyFilamentBreezy::setPasswordRules(
            [
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->uncompromised(3)
            ]
        );
    }
}

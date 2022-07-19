<?php

namespace App\Providers;

use Illuminate\Support\Collection;
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
        Collection::macro('sumRecursive', function () {
            /** @var Collection $this */
            return $this->reduce(function ($carry, $new) {
                if ( ! $carry instanceof Collection) {
                    return $new;
                }
                return $carry->mergeRecursive($new);
            })->map(fn ($item) => array_sum($item));
        });
    }
}

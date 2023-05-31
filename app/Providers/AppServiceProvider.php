<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $query) {

            if (App::environment('local')) {

                File::append(
                    storage_path('/logs/query.log'),
                    '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . '; bindings:[' . implode(', ', $query->bindings) . '] time:' . '[' . $query->time . ']' . PHP_EOL . PHP_EOL
                );
            }
        });
    }
}

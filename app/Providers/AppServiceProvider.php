<?php

namespace App\Providers;

use App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Foundation\Vite;

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
        Schema::defaultStringLength(191);
        Model::unguard();

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
        });

        TextColumn::configureUsing(function (TextColumn $column) {
            $column->extraAttributes(['class' => 'font-semibold text-sm']);
        });
    }
}

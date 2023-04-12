<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }

        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Пользователи')
                    ->icon('heroicon-s-users')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Статистика')
                    ->icon('heroicon-s-chart-bar')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Настройки')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
            ]);
        });
        Column::configureUsing(function (Column $column): void {
            $column
                ->toggleable()
                ->sortable();
        });
        TextColumn::configureUsing(function (TextColumn $column): void {
            $column
                ->searchable();
        });
    }
}

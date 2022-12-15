<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
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
        Schema::defaultStringLength(190);
        Model::unguard();
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make() 
                    ->label('My Account')
                    // ->url(UserResource::getUrl('edit',['record'=>auth()->user()]))
                    ->icon('heroicon-s-user'),
                UserMenuItem::make()
                    ->label('Manage Users')
                    ->url(UserResource::getUrl())
                    ->icon('heroicon-s-users'),
            ]);
        });
    }
}

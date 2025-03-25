<?php

namespace App\Providers;

use App\Interfaces\ChatInterface;
use App\Interfaces\TodoInterface;
use App\Observers\TodoObserver;
use App\Repositories\ChatRepository;
use Illuminate\Support\ServiceProvider;
use App\Models\Todo;
use App\Repositories\TodoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatInterface::class, ChatRepository::class);
        $this->app->bind(TodoInterface::class, TodoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Todo::observer(TodoObserver::class);
    }
}

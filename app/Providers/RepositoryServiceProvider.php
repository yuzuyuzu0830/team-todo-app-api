<?php

namespace App\Providers;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\TodoRepositoryInterface;
use App\Repositories\TodoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

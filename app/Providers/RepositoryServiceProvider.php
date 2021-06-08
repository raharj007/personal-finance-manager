<?php

namespace App\Providers;

use App\Repositories\AccountGroup\AccountGroupRepository;
use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;
use App\Repositories\Accounts\AccountsRepository;
use App\Repositories\Accounts\AccountsRepositoryInterface;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\CategoriesRepositoryInterface;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Images\ImagesRepositoryInterface;
use App\Repositories\Transactions\TransactionsRepository;
use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AccountGroupRepositoryInterface::class, AccountGroupRepository::class);
        $this->app->singleton(AccountsRepositoryInterface::class, AccountsRepository::class);
        $this->app->singleton(CategoriesRepositoryInterface::class, CategoriesRepository::class);
        $this->app->singleton(ImagesRepositoryInterface::class, ImagesRepository::class);
        $this->app->singleton(TransactionsRepositoryInterface::class, TransactionsRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

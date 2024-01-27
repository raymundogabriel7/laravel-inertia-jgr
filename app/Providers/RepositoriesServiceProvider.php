<?php

namespace App\Providers;

use App\Repositories\Eloquent\EloquentCompanyRepository;
use App\Repositories\Eloquent\EloquentEmployeeRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    
    public $bindings = [
        'App\Repositories\Interfaces\CompanyRepositoryInterface' => 'App\Repositories\Eloquent\EloquentCompanyRepository',
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\Eloquent\EloquentUserRepository',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}

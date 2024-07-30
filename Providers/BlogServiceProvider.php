<?php

namespace Modules\Blog\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Blog';

    public function boot(): void
    {
        $this->loadMigrations();
    }

    public function register(): void
    {
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Migrations'));
    }
}

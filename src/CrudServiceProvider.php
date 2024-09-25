<?php

namespace GithubMarau\Laragen;

use Illuminate\Support\ServiceProvider;
use GithubMarau\Laragen\Commands\CrudGenerator;
use GithubMarau\Laragen\Commands\PublishCrudCommand;

/**
 * Class CrudServiceProvider.
 */
class CrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CrudGenerator::class,
                //PublishCrudCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/config/crud.php' => config_path('crud.php'),
        ], 'crud');

        $this->publishes([
            __DIR__.'/../src/stubs' => resource_path('stubs/crud/'),
        ], 'stubs-crud');

        $this->publishes([
            __DIR__.'/../src/resources/views/components' => resource_path('views/components/'),
        ], 'livewire-crud');

        // $this->publishes([
        //     __DIR__.'/../src/app/Models' => app_path('models/'),
        // ], 'model-crud');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

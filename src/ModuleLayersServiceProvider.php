<?php

namespace Rezaei1993\LaravelModuleLayers;

use Illuminate\Support\ServiceProvider;
use Rezaei1993\LaravelModuleLayers\Commands\ScaffoldAdditionalLayersCommand;

class ModuleLayersServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register(): void
    {
        $this->commands([
            ScaffoldAdditionalLayersCommand::class,
        ]);
    }
}

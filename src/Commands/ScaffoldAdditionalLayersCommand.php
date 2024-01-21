<?php

namespace Rezaei1993\LaravelModuleLayers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class ScaffoldAdditionalLayersCommand extends Command
{
    // example: make:scaffolding User (makes is with V1)
    // example: make:scaffolding User --version_number=2 (makes it with V2)

    protected $signature = 'make:scaffolding {module} {--version_number=}';

    protected $description = 'Create additional layers (External and Services) for the specified module';

    public function handle(): int
    {
        $module = $this->argument('module');
        $version = $this->getOptionVersion();

        if (!is_dir(base_path("Modules/$module"))) {
            $this->error("Module '$module' does not exist.");
            return $this->failure();
        }

        $directories = $this->getDirectories($module, $version);

        $this->makeDirectories($directories);

        $this->info("Additional layers (External and Services) for module '$module' have been created.");

        return $this->success();
    }

    protected function getOptionVersion(): string
    {
        return $this->option('version_number') ? 'V'.$this->option('version_number') : 'V1';
    }

    protected function getDirectories(string $module, string $version): array
    {
        return [
            "Modules/$module/External/Repositories/$version/Contracts",
            "Modules/$module/External/Apis/Contracts",
            "Modules/$module/Services/$version/Contracts",
            "Modules/$module/Routes/$version",
            "Modules/$module/Http/Controllers/$version/Admin",
            "Modules/$module/Http/Controllers/$version/Front",
            "Modules/$module/Http/Requests/$version/Admin",
            "Modules/$module/Http/Requests/$version/Front",
            "Modules/$module/Transformers/$version/Admin",
            "Modules/$module/Transformers/$version/Front",
            "Modules/$module/Tests/Feature/$version/Admin",
            "Modules/$module/Tests/Feature/$version/Front",
            "Modules/$module/Tests/Unit/$version/Admin",
            "Modules/$module/Tests/Unit/$version/Front",
        ];
    }

    protected function makeDirectories(array $directories): void
    {
        foreach ($directories as $directory) {
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
                File::put("$directory/.gitkeep", "");
            }
        }
    }

    protected function success(): int
    {
        return SymfonyCommand::SUCCESS;
    }

    protected function failure(): int
    {
        return SymfonyCommand::FAILURE;
    }
}

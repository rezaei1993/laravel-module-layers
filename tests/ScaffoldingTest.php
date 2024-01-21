<?php

namespace Rezaei1993\LaravelModuleLayers\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Tests\TestCase;

class ScaffoldingTest extends TestCase
{
    protected string $moduleName = 'TestModule';
    protected int $versionNumber = 1;

    public function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(base_path("Modules/{$this->moduleName}"));
        File::makeDirectory(base_path("Modules/{$this->moduleName}"));
    }


    protected function runScaffoldingCommand(array $options = []): int
    {
        return Artisan::call('make:scaffolding', $options);
    }

    public function testScaffoldAdditionalLayersCommand()
    {
        $exitCode = $this->runScaffoldingCommand([
            'module' => $this->moduleName,
            '--version_number' => $this->versionNumber,
        ]);

        $this->assertEquals(0, $exitCode);
        $this->assertScaffoldingSuccess();
    }


    public function test_running_scaffolding_command_should_use_v1_if_no_version_option_is_provided()
    {
        $exitCode = $this->runScaffoldingCommand([
            'module' => $this->moduleName,
        ]);

        $this->assertEquals(0, $exitCode);
        $this->assertScaffoldingSuccess();
    }


    public function test_running_scaffolding_command_should_return_error_if_no_the_provided_module_doesnt_exist()
    {
        $newModule = 'New Module';

        $exitCode = $this->runScaffoldingCommand([
            'module' => $newModule,
        ]);

        $this->assertEquals(1, $exitCode);
        $this->assertStringContainsString("Module '$newModule' does not exist.", Artisan::output());
    }

    public function test_running_scaffolding_command_should_return_error_if_no_module_is_provided()
    {
        try {
            $this->runScaffoldingCommand();
        } catch (RuntimeException $exception) {
            $this->assertEquals('Not enough arguments (missing: "module").', $exception->getMessage());
        }
    }

    protected function assertScaffoldingSuccess(): void
    {
        $basePath = base_path("Modules/{$this->moduleName}");

        $directories = [
            "External/Repositories/V{$this->versionNumber}/Contracts",
            "External/Apis/Contracts",
            "Services/V{$this->versionNumber}/Contracts",
            "Routes/V{$this->versionNumber}",
            "Http/Controllers/V{$this->versionNumber}/Admin",
            "Http/Controllers/V{$this->versionNumber}/Front",
            "Http/Requests/V{$this->versionNumber}/Admin",
            "Http/Requests/V{$this->versionNumber}/Front",
            "Transformers/V{$this->versionNumber}/Admin",
            "Transformers/V{$this->versionNumber}/Front",
            "Tests/Feature/V{$this->versionNumber}/Admin",
            "Tests/Feature/V{$this->versionNumber}/Front",
            "Tests/Unit/V{$this->versionNumber}/Admin",
            "Tests/Unit/V{$this->versionNumber}/Front",
        ];

        foreach ($directories as $directory) {
            $this->assertGitKeepExists("$basePath/$directory");
        }
    }


    protected function assertGitKeepExists(string $directory): void
    {
        $this->assertDirectoryExists($directory, "Directory $directory does not exist.");
        $this->assertFileExists("$directory/.gitkeep", ".gitkeep file not found in $directory.");
    }


    public function tearDown(): void
    {
        parent::tearDown();
        File::deleteDirectory(base_path("Modules/{$this->moduleName}"));
    }

}

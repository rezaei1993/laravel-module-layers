# Laravel Module Layers Command

A Laravel Artisan command for scaffolding additional layers (External and Services) for a specified module.

## Installation

To use this command in your Laravel project, you can follow these steps:

1. Install the package using composer:

``` composer require rezaei1993/laravel-module-layers ```

2. After installation, Laravel will automatically discover the package.

## Usage

Run the following Artisan command to create additional layers for a module:

``` php artisan make:scaffolding {module} {--version_number=} ```

Replace {module} with the name of the existing module.

Use the optional --version_number flag to specify the version number. If not provided, the default version is set to '
V1'.

# Examples:

### Create additional layers for 'User' module with default version (V1)

php artisan make:scaffolding User

### Create additional layers for 'User' module with version 'V2'

php artisan make:scaffolding User --version_number=2

## Directory Structure

The command generates the following directory structure within your Laravel project:

```
Modules/{module}/
|-- External/
| |-- Repositories/{version}/Contracts
| |-- Apis/Contracts
|-- Services/
| |-- {version}/Contracts
|-- Routes/{version}
|-- Http/
| |-- Controllers/{version}/Admin
| |-- Controllers/{version}/Front
|-- Requests/{version}/Admin
|-- Requests/{version}/Front
|-- Transformers/{version}/Admin
|-- Transformers/{version}/Front
|-- Tests/
| |-- Feature/{version}/Admin
| |-- Feature/{version}/Front
| |-- Unit/{version}/Admin
| |-- Unit/{version}/Front
```

## Notes

This command assumes that your modules are located in the Modules directory within your Laravel project.

## License

This Laravel module layers command is open-source software licensed under the MIT license.

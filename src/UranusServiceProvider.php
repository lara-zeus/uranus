<?php

namespace LaraZeus\Uranus;

use LaraZeus\Uranus\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UranusServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-uranus';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasCommand(InstallCommand::class);
    }
}

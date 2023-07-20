<?php

namespace AtakanAtici\EDM;

use AtakanAtici\EDM\Commands\EDMCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EDMServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-edm')
            ->hasConfigFile('edm')
            ->hasMigration('create_laravel-edm_table')
            ->hasCommand(EDMCommand::class);
    }
}

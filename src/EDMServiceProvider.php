<?php

namespace AtakanAtici\EDM;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AtakanAtici\EDM\Commands\EDMCommand;

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
            ->hasConfigFile()
            ->hasMigration('create_laravel-edm_table')
            ->hasCommand(EDMCommand::class);
    }
}

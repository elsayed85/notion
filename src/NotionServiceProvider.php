<?php

namespace Elsayed85\Notion;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Elsayed85\Notion\Commands\NotionCommand;

class NotionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('notion')
            ->hasConfigFile();
    }
}

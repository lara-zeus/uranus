<?php

namespace LaraZeus\Uranus\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

trait Loader
{
    // @phpstan-ignore-next-line
    public static function collectClasses(string $path, string $namespace): Collection
    {
        if (! is_dir($path)) {
            return collect();
        }

        return collect(
            self::buildClasses(
                self::loadClasses($path, $namespace)
            )
        );
    }

    protected static function buildClasses(array $classes): array
    {
        $allClasses = [];
        foreach ($classes as $class) {
            $allClasses[str($class)->explode('\\')->last()] = $class;
        }

        return $allClasses;
    }

    public static function loadClasses(string $path, string $namespace): array
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach ((new Finder())->in($path)->files() as $className) {
            $classes[] = $namespace . $className->getFilenameWithoutExtension();
        }

        return $classes;
    }
}

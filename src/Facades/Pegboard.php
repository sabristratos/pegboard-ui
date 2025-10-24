<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void toast(?string $text = null, ?string $heading = null, string $variant = 'default', int $duration = 5000)
 *
 * @see \Stratos\Pegboard\Support\Pegboard
 */
class Pegboard extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Stratos\Pegboard\Support\Pegboard::class;
    }
}

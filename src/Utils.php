<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use DateTime;
use Ramsey\Uuid\Uuid;
use ReflectionClass;

use function Lambdish\Phunctional\filter;

final class Utils
{
    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    public static function filesIn(string $path, string $fileType): array
    {
        return filter(
            static fn(string $possibleModule) => strstr($possibleModule, $fileType),
            scandir($path)
        );
    }

    public static function extractClassName(object $object): string
    {
        return (new ReflectionClass($object))->getShortName();
    }

    public static function iterableToArray(iterable $iterable): array
    {
        if (is_array($iterable)) {
            return $iterable;
        }

        return iterator_to_array($iterable);
    }

    public static function generateUuid(): string
    {
        return (Uuid::uuid4())->toString();
    }

    public static function generateNowDateTimeWithFormat(string $format = 'Y-m-d H:i:s'): string
    {
        return date($format);
    }

    public static function generateNowDateTimeMillisecondsWithFormat(string $format = 'Y-m-d H:i:s.u'): string
    {
        $now = DateTime::createFromFormat(
            'U.u',
            number_format(microtime(true), 6, '.', '')
        );

        return $now->format($format);
    }
}

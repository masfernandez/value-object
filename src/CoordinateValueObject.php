<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use LongitudeOne\Spatial\Exception\InvalidValueException;
use LongitudeOne\Spatial\PHP\Types\Geometry\Point;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class CoordinateValueObject extends ValueObject
{
    private Point $point;

    /**
     * @throws ValueObjectException
     */
    public function __construct(float $x, float $y)
    {
        parent::__construct([$x, $y]);
        try {
            $this->point = new Point($x, $y);
        } catch (InvalidValueException $e) {
            throw new ValueObjectException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\Collection(
                [
                    'fields' => [
                        'x' => new Constraints\NotNull(),
                        'y' => new Constraints\NotNull(),
                    ],
                ]
            ),
        ];
    }

    public function value(): array
    {
        return $this->point->toArray();
    }

    public function __toString(): string
    {
        return $this->point->toJson();
    }
}
<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use LongitudeOne\Spatial\PHP\Types\Geometry\Point;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class CoordinateValueObject extends ValueObject
{
    private readonly Point $point;

    public function __construct(float $x, float $y)
    {
        parent::__construct(['x' => $x, 'y' => $y]);
        $this->point = new Point($x, $y);
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

    /**
     * @return float[]
     */
    public function value(): array
    {
        return $this->point->toArray();
    }

    public function __toString(): string
    {
        return "[{$this->point->getX()},{$this->point->getY()}]";
    }
}

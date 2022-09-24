<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class FloatValueObject extends ValueObject
{
    private readonly float $value;

    public function __construct(float $value)
    {
        parent::__construct($value);
        $this->value = $value;
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\Positive(),
            new Constraints\NotNull(),
        ];
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}

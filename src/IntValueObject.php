<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class IntValueObject extends ValueObject
{
    private readonly int $value;

    public function __construct(int $value)
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
            new Constraints\NotNull(),
            new Constraints\Positive(),
        ];
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}

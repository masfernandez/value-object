<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class StringValueObject extends ValueObject
{
    private readonly string $value;

    public function __construct(string $value)
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
            new Constraints\Length(['min' => 1]),
        ];
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

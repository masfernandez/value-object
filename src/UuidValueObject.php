<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class UuidValueObject extends ValueObject
{
    private Uuid $value;

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
        $this->value = new Uuid($value);
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\Uuid(),
        ];
    }

    public function value(): string
    {
        return $this->value->toRfc4122();
    }

    public function __toString(): string
    {
        return $this->value->toRfc4122();
    }
}

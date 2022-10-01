<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Exception;
use Masfernandez\ValueObject\Exception\ValueObjectException;
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
        try {
            $this->value = new Uuid($value);
        } catch (Exception $exception) {
            throw new ValueObjectException(
                message:  $exception->getMessage(),
                previous: $exception,
            );
        }
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

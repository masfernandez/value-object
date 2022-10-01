<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Stringable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validation;

abstract class ValueObject implements Stringable
{
    /**
     * @throws ValueObjectException
     */
    public function __construct(mixed $value)
    {
        $this->validateInput($value);
    }

    /**
     * @return Constraint[]
     */
    abstract protected static function setConstraints(): array;

    abstract public function value();

    abstract public function __toString(): string;

    /**
     * @throws ValueObjectException
     */
    private function validateInput(mixed $value): void
    {
        $violations = Validation::createValidator()->validate($value, static::setConstraints());
        if (count($violations) > 0) {
            $detail = $violations[0]->getMessage();
            throw new ValueObjectException((string)$detail);
        }
    }

    /**
     * @return Constraint[]
     */
    public static function getConstraints(): array
    {
        return static::setConstraints();
    }
}

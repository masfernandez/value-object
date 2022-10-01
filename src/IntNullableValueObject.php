<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class IntNullableValueObject extends ValueObject
{
    private readonly ?int $value;

    public function __construct(
        ?int $value
    ) {
        parent::__construct($value);
        $this->value = $value;
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\AtLeastOneOf(
                [
                    'constraints' => [
                        new Constraints\Positive(),
                        new Constraints\IsNull(),
                    ],
                ],
            ),
        ];
    }

    public function value(): ?int
    {
        return $this->value;
    }

    /**
     * @throws ValueObjectException
     */
    public function __toString(): string
    {
        if ($this->value === null) {
            throw new ValueObjectException('Null value');
        }

        return (string)$this->value;
    }
}

<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class NullableUuidValueObject extends ValueObject
{
    private ?Uuid $value;

    public function __construct(
        ?string $value,
    ) {
        parent::__construct($value);
        $this->value = ($value !== null) ? new Uuid($value) : null;
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
                        new Constraints\Uuid(),
                        new Constraints\IsNull(),
                    ],
                ],
            ),
        ];
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value === null ? $this->value->toRfc4122() : 'null';
    }
}

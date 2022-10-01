<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use Exception;
use Masfernandez\ValueObject\Exception\ValueObjectException;
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
        try {
            $this->value = ($value !== null) ? new Uuid($value) : null;
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
        return $this->value?->toRfc4122();
    }

    /**
     * @throws ValueObjectException
     */
    public function __toString(): string
    {
        if ($this->value === null) {
            throw new ValueObjectException('Null value');
        }

        return $this->value->toRfc4122();
    }
}

<?php

namespace Masfernandez\ValueObject;

use DateTime;
use DateTimeInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class DateTimeValueObject extends ValueObject
{
    private readonly DateTimeInterface $value;

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->value = DateTime::createFromFormat(DATE_W3C, $value);
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\DateTime(DATE_W3C)
        ];
    }

    public function value(): DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format(DATE_W3C);
    }
}

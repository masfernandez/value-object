<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

abstract class DateTimeMillisecondsValueObject extends ValueObject
{
    final public const FORMAT = 'Y-m-d\TH:i:s.uP';

    private readonly DateTimeInterface $value;

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->value = DateTime::createFromFormat(self::FORMAT, $value)
            ->setTimezone(new DateTimeZone('UTC'));
    }

    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\DateTime(self::FORMAT),
        ];
    }

    public function value(): DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format(self::FORMAT);
    }
}

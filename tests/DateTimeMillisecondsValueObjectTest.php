<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use DateTime;
use Masfernandez\ValueObject\DateTimeMillisecondsValueObject;
use Masfernandez\ValueObject\Exception\ValueObjectException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class DateTimeMillisecondsValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value should not be blank.');

        new class ('') extends DateTimeMillisecondsValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends DateTimeMillisecondsValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends DateTimeMillisecondsValueObject {
        };
    }

    public function testValueMethodOnWrongDate(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is not a valid datetime.');

        $valueExpected = '2022-10-01T09:40:00';

        $stringValueObject = new class ($valueExpected) extends DateTimeMillisecondsValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testValueMethod(): void
    {
        $value = '2022-10-01T09:40:00.000000+02:00';

        $stringValueObject = new class ($value) extends DateTimeMillisecondsValueObject {
        };

        $expected = DateTime::createFromFormat(DateTimeMillisecondsValueObject::FORMAT, $value);
        $this->assertEquals($expected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $value = '2022-10-01T09:40:00.000000+02:00';

        $stringValueObject = new class ($value) extends DateTimeMillisecondsValueObject {
        };

        $valueExpectedInUtc = '2022-10-01T07:40:00.000000+00:00';

        $this->assertEquals($valueExpectedInUtc, $stringValueObject->__toString());
        $this->assertEquals($valueExpectedInUtc, $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('2022-10-01T09:40:00.0000000+02:00') extends DateTimeMillisecondsValueObject {
            /** @return Constraint[] */
            protected static function setConstraints(): array
            {
                return [
                    new Constraints\Length(['max' => 10])
                ];
            }
        };
    }
}

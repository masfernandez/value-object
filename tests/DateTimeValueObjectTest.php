<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use DateTime;
use Masfernandez\ValueObject\DateTimeValueObject;
use Masfernandez\ValueObject\Exception\ValueObjectException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class DateTimeValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value should not be blank.');

        new class ('') extends DateTimeValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends DateTimeValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends DateTimeValueObject {
        };
    }

    public function testValueMethodOnWrongDate(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is not a valid datetime.');

        $valueExpected = 'string';

        $stringValueObject = new class ($valueExpected) extends DateTimeValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testValueMethod(): void
    {
        $valueExpected = '2022-10-01T09:40:00+02:00';

        $stringValueObject = new class ($valueExpected) extends DateTimeValueObject {
        };

        $this->assertEquals(DateTime::createFromFormat(DATE_W3C, $valueExpected), $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $valueExpected = '2022-10-01T09:40:00+02:00';

        $stringValueObject = new class ($valueExpected) extends DateTimeValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
        $this->assertEquals($valueExpected, $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('2022-10-01T09:40:00+02:00') extends DateTimeValueObject {
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

<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\IntNullableValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class IntNullableValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(TypeError::class);

        new class ('') extends IntNullableValueObject {
        };
    }

    public function testNullValue(): void
    {
        $valueExpected = null;

        $valueObject = new class ($valueExpected) extends IntNullableValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testIntValue(): void
    {
        $valueExpected = 123;

        $valueObject = new class ($valueExpected) extends IntNullableValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testValueMethod(): void
    {
        $valueExpected = 123;

        $stringValueObject = new class ($valueExpected) extends IntNullableValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $stringValueObject = new class (123) extends IntNullableValueObject {
        };

        $this->assertEquals('123', $stringValueObject->__toString());
        $this->assertEquals('123', $stringValueObject);
    }

    public function testToStringOnNullMethod(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('Null value');

        $stringValueObject = new class (null) extends IntNullableValueObject {
        };

        $this->assertEquals('123', $stringValueObject->__toString());
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class (1234567891011) extends IntNullableValueObject {
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

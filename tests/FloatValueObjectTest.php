<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\FloatValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class FloatValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(TypeError::class);

        new class ('') extends FloatValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends FloatValueObject {
        };
    }

    public function testFloatValue(): void
    {
        $valueExpected = 123.00001;

        $valueObject = new class ($valueExpected) extends FloatValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testValueMethod(): void
    {
        $valueExpected = 123.00001;

        $stringValueObject = new class ($valueExpected) extends FloatValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $stringValueObject = new class (123.00001) extends FloatValueObject {
        };

        $this->assertEquals('123.00001', $stringValueObject->__toString());
        $this->assertEquals('123.00001', $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class (123.00000001) extends FloatValueObject {
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

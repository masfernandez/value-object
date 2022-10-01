<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\IntValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class IntValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(TypeError::class);

        new class ('') extends IntValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends IntValueObject {
        };
    }

    public function testIntValue(): void
    {
        $valueExpected = 123;

        $valueObject = new class ($valueExpected) extends IntValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testValueMethod(): void
    {
        $valueExpected = 123;

        $stringValueObject = new class ($valueExpected) extends IntValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $stringValueObject = new class (123) extends IntValueObject {
        };

        $this->assertEquals('123', $stringValueObject->__toString());
        $this->assertEquals('123', $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class (1234567891011) extends IntValueObject {
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

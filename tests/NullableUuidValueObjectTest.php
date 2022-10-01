<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\NullableUuidValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class NullableUuidValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('Invalid UUID: "".');

        new class ('') extends NullableUuidValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends NullableUuidValueObject {
        };
    }

    public function testWrongUuidValue(): void
    {
        $this->expectException(ValueObjectException::class);

        new class ('b17e95c8-9809-4024-a310-3012ed40abb-') extends NullableUuidValueObject {
        };
    }

    public function testValueMethod(): void
    {
        $valueObjectExpected = Uuid::v4()->toRfc4122();

        $valueObject = new class ($valueObjectExpected) extends NullableUuidValueObject {
        };

        $this->assertEquals($valueObjectExpected, $valueObject->value());
    }

    public function testValueMethodOnNull(): void
    {
        $valueExpected = null;

        $stringValueObject = new class (null) extends NullableUuidValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    /**
     * @throws ValueObjectException
     */
    public function testToStringMethod(): void
    {
        $valueObjectExpected = Uuid::v4()->toRfc4122();

        $valueObject = new class ($valueObjectExpected) extends NullableUuidValueObject {
        };

        $this->assertEquals($valueObjectExpected, $valueObject->__toString());
    }

    public function testToStringMethodOnNull(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('Null value');

        $valueExpected     = null;
        $stringValueObject = new class (null) extends NullableUuidValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('string too length') extends NullableUuidValueObject {
            /** @return Constraint[] */
            protected static function setConstraints(): array
            {
                return [
                    new Constraints\Length(['max' => 10]),
                ];
            }
        };
    }
}

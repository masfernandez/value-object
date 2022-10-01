<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\NullableStringValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class NullableStringValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too short. It should have 1 character or more.');

        new class ('') extends NullableStringValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends NullableStringValueObject {
        };
    }

    public function testValueMethod(): void
    {
        $valueExpected = 'string';

        $stringValueObject = new class ($valueExpected) extends NullableStringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testValueMethodOnNull(): void
    {
        $valueExpected = null;

        $stringValueObject = new class (null) extends NullableStringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testStringMethodOnNull(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('Null value');

        $valueExpected     = null;
        $stringValueObject = new class (null) extends NullableStringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
    }

    /**
     * @throws ValueObjectException
     */
    public function testToStringMethodOnNull(): void
    {
        $valueExpected     = 'hi there';
        $stringValueObject = new class ($valueExpected) extends NullableStringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('string too length') extends NullableStringValueObject {
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

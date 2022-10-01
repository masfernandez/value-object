<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\MixedValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

class MixedValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value should not be blank.');

        new class ('') extends MixedValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value should not be blank.');

        new class (null) extends MixedValueObject {
        };
    }

    public function testIntValue(): void
    {
        $valueExpected = 123;

        $valueObject = new class ($valueExpected) extends MixedValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testValueMethod(): void
    {
        $valueExpected = 'string';

        $stringValueObject = new class ($valueExpected) extends MixedValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $valueExpected = 'hey';

        $stringValueObject = new class ($valueExpected) extends MixedValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
        $this->assertEquals($valueExpected, $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('string too length') extends MixedValueObject {
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

<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\StringValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class StringValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too short. It should have 1 character or more.');

        new class ('') extends StringValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends StringValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends StringValueObject {
        };
    }

    public function testValueMethod(): void
    {
        $valueExpected = 'string';

        $stringValueObject = new class ($valueExpected) extends StringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $valueExpected = 'hey';

        $stringValueObject = new class ($valueExpected) extends StringValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
        $this->assertEquals($valueExpected, $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('string too length') extends StringValueObject {
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

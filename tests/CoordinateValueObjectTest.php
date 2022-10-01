<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\CoordinateValueObject;
use Masfernandez\ValueObject\Exception\ValueObjectException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class CoordinateValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(TypeError::class);

        new class ('') extends CoordinateValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends CoordinateValueObject {
        };
    }

    public function testStringValue(): void
    {
        $this->expectException(TypeError::class);

        new class ('1', '2') extends CoordinateValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        $valueExpected = 123;

        $valueObject = new class ($valueExpected) extends CoordinateValueObject {
        };

        $this->assertEquals($valueExpected, $valueObject->value());
    }

    public function testValueMethod(): void
    {
        $stringValueObject = new class (1, 2) extends CoordinateValueObject {
        };

        $this->assertEquals([1, 2], $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $stringValueObject = new class (1, 2) extends CoordinateValueObject {
        };

        $this->assertEquals('[1,2]', $stringValueObject->__toString());
        $this->assertEquals('[1,2]', $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value should be of type string.');

        new class (1, 2) extends CoordinateValueObject {
            /** @return Constraint[] */
            protected static function setConstraints(): array
            {
                return [
                    new Constraints\Length(['max' => 1])
                ];
            }
        };
    }
}

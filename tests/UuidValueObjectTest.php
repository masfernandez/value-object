<?php

declare(strict_types=1);

namespace Masfernandez\ValueObject\Tests;

use Masfernandez\ValueObject\Exception\ValueObjectException;
use Masfernandez\ValueObject\UuidValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;
use TypeError;

class UuidValueObjectTest extends TestCase
{
    public function testEmptyValue(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('Invalid UUID: "".');

        new class ('') extends UuidValueObject {
        };
    }

    public function testNullValue(): void
    {
        $this->expectException(TypeError::class);

        new class (null) extends UuidValueObject {
        };
    }

    public function testIntValue(): void
    {
        $this->expectException(TypeError::class);

        new class (123) extends UuidValueObject {
        };
    }

    public function testValueMethod(): void
    {
        $valueExpected = '4f75735f-ec2e-4304-8b30-3080393dee5d';

        $stringValueObject = new class ($valueExpected) extends UuidValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->value());
    }

    public function testToStringMethod(): void
    {
        $valueExpected = '4f75735f-ec2e-4304-8b30-3080393dee5d';

        $stringValueObject = new class ($valueExpected) extends UuidValueObject {
        };

        $this->assertEquals($valueExpected, $stringValueObject->__toString());
        $this->assertEquals($valueExpected, $stringValueObject);
    }

    public function testLengthValueCustomConstraints(): void
    {
        $this->expectException(ValueObjectException::class);
        $this->expectExceptionMessage('This value is too long. It should have 10 characters or less.');

        new class ('string too length') extends UuidValueObject {
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
